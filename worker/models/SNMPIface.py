from sqlalchemy import Column, Integer, String, DateTime
from sqlalchemy.orm import declarative_base

Base = declarative_base()


class SNMPIface(Base):
    __tablename__ = 'snmp_iface'
    id = Column(Integer, primary_key=True)
    device_id = Column(Integer, )
    identifier = Column(String)
    name = Column(String)
    type = Column(String)
    mtu = Column(String)
    speed = Column(String)
    mac = Column(String)
    updated_at = Column(DateTime)
    created_at = Column(DateTime)
