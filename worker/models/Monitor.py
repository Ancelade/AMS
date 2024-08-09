import logging
import threading
import time
from datetime import datetime

from sqlalchemy import Column, Integer, String, DateTime
from sqlalchemy.orm import declarative_base

from NotifUtils import notify
from Sessions import getSession
from models.Alert import Alert

Base = declarative_base()


class Monitor(Base):
    __tablename__ = 'monitors'
    __enabled__ = False
    __session__ = None
    id = Column(Integer, primary_key=True)
    name = Column(String)
    host = Column(String)
    port = Column(Integer, nullable=True)
    timeout = Column(Integer)
    interval = Column(Integer)
    last_latency = Column(Integer, default=0)
    retry = Column(Integer)
    keyword = Column(String, nullable=True)
    type = Column(String)
    status = Column(Integer, default=0)
    n_down = Column(Integer, default=0)
    n_up = Column(Integer, default=0)
    community = Column(String)
    username = Column(String)
    password = Column(String)
    n_down_total = Column(Integer, default=0)
    n_up_total = Column(Integer, default=0)
    device_id = Column(Integer)
    updated_at = Column(DateTime)
    created_at = Column(DateTime)

    def setSession(self, session):
        self.__session__ = session

    def start(self):
        self.__enabled__ = True
        thread = threading.Thread(target=self.check)
        thread.daemon = True
        thread.start()

    def stop(self):
        self.__enabled__ = False

    def check(self):
        while self.__enabled__:

            mon_module = __import__('checkers.' + self.type, fromlist=[self.type])

            monitor = getattr(mon_module, self.type)(self)

            check_result = monitor.check()
            time.sleep(self.interval)
            if check_result >= 0:
                self.last_latency = check_result
                self.n_up = self.n_up + 1
                self.n_up_total = self.n_up_total + 1
                if self.status == 2:
                    self.n_down = 0
            else:
                self.last_latency = 0
                self.n_down = self.n_down + 1
                self.n_down_total = self.n_down_total + 1
                if self.status == 2:
                    if self.n_down == 1:
                        self.onWarningEvent()
                if self.status == 1:
                    self.n_up = 0

            if self.n_down >= self.retry and self.status != 1:
                self.status = 1
                self.n_up = 0
                self.onDownEvent()

            if self.status != 2 and self.n_up >= self.retry:
                self.status = 2
                self.n_down = 0
                self.onUpEvent()

            self.updated_at = datetime.now()
            self.__session__.commit()
            self.__session__.flush()
            time.sleep(self.interval)

        self.__session__.close()

    def onUpEvent(self):
        logging.info(self.name + ' is now  UP')
        notify("🟢 " + self.name + " is now alive")
        session = getSession()
        event = Alert(monitor_id=self.id, state="UP", updated_at=datetime.now(), created_at=datetime.now())
        session.add(event)
        session.commit()
        session.close()

    def onDownEvent(self):
        logging.error(self.name + ' is now DOWN')
        notify("🔴 " + self.name + " appears to be off-line")
        session = getSession()
        event = Alert(monitor_id=self.id, state="DOWN", updated_at=datetime.now(), created_at=datetime.now())
        session.add(event)
        session.commit()
        session.close()

    def onWarningEvent(self):
        session = getSession()
        event = Alert(monitor_id=self.id, state="WARN", updated_at=datetime.now(), created_at=datetime.now())
        session.add(event)
        session.commit()
        session.close()
