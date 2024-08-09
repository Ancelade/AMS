from sqlalchemy import Column, Integer, String, DateTime
from sqlalchemy.orm import declarative_base

Base = declarative_base()


class Notifier(Base):
    __tablename__ = 'notifiers'
    id = Column(Integer, primary_key=True)
    type = Column(String)
    webhook = Column(String)
    updated_at = Column(DateTime)
    created_at = Column(DateTime)
