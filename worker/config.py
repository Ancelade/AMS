from dotenv import load_dotenv
import os


load_dotenv("../.env")


# Récupérer les variables d'environnement
CONFIG_MYSQL_HOST = os.environ.get("DB_HOST")
CONFIG_MYSQL_USER = os.environ.get("DB_USERNAME")
CONFIG_MYSQL_PASSWORD = os.environ.get("DB_PASSWORD")
CONFIG_MYSQL_DATABASE = os.environ.get("DB_DATABASE")


CONFIG_INFLUX_HOST = os.environ.get("INFLUX_HOST")
CONFIG_INFLUX_USER = os.environ.get("INFLUX_USERNAME")
CONFIG_INFLUX_PASSWORD = os.environ.get("INFLUX_PASSWORD")
CONFIG_INFLUX_DATABASE = os.environ.get("INFLUX_DB")



if CONFIG_MYSQL_PASSWORD is None:
    CONFIG_MYSQL_PASSWORD = ""

if CONFIG_INFLUX_PASSWORD is None:
    CONFIG_INFLUX_PASSWORD = ""
# Assurez-vous que les variables sont définies
if CONFIG_MYSQL_HOST is None or CONFIG_MYSQL_USER is None is None or CONFIG_MYSQL_DATABASE is None:
    raise ValueError("Les variables d'environnement ne sont pas correctement définies.")
