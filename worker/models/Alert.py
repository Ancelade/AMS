from sqlalchemy import Column, Integer, String, DateTime
from sqlalchemy.orm import declarative_base

Base = declarative_base()


class Alert(Base):
    __tablename__ = 'alerts'
    id = Column(Integer, primary_key=True)
    monitor_id = Column(Integer)
    state = Column(String)
    updated_at = Column(DateTime)
    created_at = Column(DateTime)
