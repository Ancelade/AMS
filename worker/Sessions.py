import logging
import time

from influxdb import InfluxDBClient
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

from config import CONFIG_MYSQL_USER, CONFIG_MYSQL_PASSWORD, CONFIG_MYSQL_HOST, CONFIG_MYSQL_DATABASE, CONFIG_INFLUX_DATABASE, CONFIG_INFLUX_PASSWORD, CONFIG_INFLUX_USER, CONFIG_INFLUX_HOST


points = []


def getSession():
    engine = create_engine(
        "mysql+pymysql://" + CONFIG_MYSQL_USER + ":" + CONFIG_MYSQL_PASSWORD + "@" + CONFIG_MYSQL_HOST + "/" + CONFIG_MYSQL_DATABASE + "?charset=utf8mb4",
        pool_size=20, max_overflow=1000)

    Session = sessionmaker(bind=engine, autoflush=False)
    return Session()


def getInflux():
    # Configuration d'InfluxDB
    session = getSession()
    host = CONFIG_INFLUX_HOST

    user = CONFIG_INFLUX_USER
    passwd = CONFIG_INFLUX_PASSWORD
    db = CONFIG_INFLUX_DATABASE


    # Créer un client InfluxDB
    client = InfluxDBClient(host, 8086, user, passwd, db)
    if not any(db['name'] == db for db in client.get_list_database()):
        # Créer la base de données si elle n'existe pas
        client.create_database(db)
    return client



def savePoint(data):
    global points

    points.append(data)



def threadSave():
    global points
    while True:
        p = points
        points = []
        client = getInflux()
        if client:
            logging.info("Sauvegarde influx: " + str(len(p)) + " points")
            client.write_points(p)
            client.close()
        time.sleep(2)


