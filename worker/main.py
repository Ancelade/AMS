import logging
import time
from threading import Thread
from typing import List
import sentry_sdk
from colorlog import ColoredFormatter

from MonitorEngine import MonitorEngine
from NotifUtils import send_telegram
from Sessions import getSession, threadSave, getInflux
from models.Monitor import Monitor

logger = logging.getLogger()
logger.setLevel(logging.ERROR)  # Niveau de journalisation global

# Créez un gestionnaire de console avec une mise en forme colorée
console_handler = logging.StreamHandler()
formatter = ColoredFormatter(
    "%(log_color)s%(asctime)s - %(name)s - %(levelname)s - %(message)s",
    datefmt="%H:%M:%S",
    log_colors={
        'DEBUG': 'cyan',
        'INFO': 'green',
        'WARNING': 'yellow',
        'ERROR': 'red',
        'CRITICAL': 'red,bg_white',
    }
)



sentry_sdk.init(
    dsn="https://8f58f8042ef9f2b27ebde3af37a537cb@o4507686590611456.ingest.de.sentry.io/4507746319401040",
    # Set traces_sample_rate to 1.0 to capture 100%
    # of transactions for performance monitoring.
    traces_sample_rate=1.0,
    # Set profiles_sample_rate to 1.0 to profile 100%
    # of sampled transactions.
    # We recommend adjusting this value in production.
    profiles_sample_rate=1.0,
)


console_handler.setFormatter(formatter)

# Ajoutez le gestionnaire de console au logger
logger.addHandler(console_handler)

ALL_MONITORS: List[Monitor] = []
logging.info("Connexion à la base de donnees")

monitor_engine = MonitorEngine()
getInflux()
Thread(target=threadSave, daemon=True).start()
while True:
    logging.info("Mise à jours de moniteurs")
    ALL_MONITORS = []
    monitor_engine.reset()
    monitors = getSession().query(Monitor).filter(Monitor.type != "SNMP").all()


    for monitor_origin in monitors:
        ss = getSession()

        monitor = ss.query(Monitor).filter_by(id=monitor_origin.id).first()
        monitor.setSession(ss)
        ALL_MONITORS.append(monitor)
        monitor_engine.add(monitor)
    logging.info("Mise à jours des moniteurs: OK")
    time.sleep(30)

