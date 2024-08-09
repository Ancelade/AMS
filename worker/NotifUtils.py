import json
import logging

import requests

from Sessions import getSession
from models.Notifier import Notifier


def send_slack(message):
    try:
        session = getSession()
        monitor = session.query(Notifier).filter_by(type="slack").first()
        if monitor:
            webhook_url = monitor.webhook
            data = {'text': message}
            headers = {'Content-Type': 'application/json'}
            requests.post(webhook_url, data=json.dumps(data), headers=headers)
            session.close()
    except Exception as e:
        logging.error(e)
        pass


def send_telegram(message):
    try:
        session = getSession()
        monitor = session.query(Notifier).filter_by(type="telegram").first()
        if monitor:
            telegram_api_url = monitor.webhook + "&text=" + message
            requests.get(telegram_api_url)
    except Exception as e:
        logging.error(e)


def send_discord(message):
    try:
        session = getSession()
        monitor = session.query(Notifier).filter_by(type="discord").first()
        if monitor:
            payload = {
                'content': message
            }
            headers = {
                'Content-Type': 'application/json'
            }
            requests.post(monitor.webhook, json=payload, headers=headers)
    except Exception as e:
            logging.error(e)


def notify(message):
    try:
        send_slack(message)
        send_discord(message)
        send_telegram(message)
    except Exception as e:
        logging.error(e)
