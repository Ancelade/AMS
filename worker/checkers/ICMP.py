import time
from datetime import datetime

import scapy
import scapy.all as scapy
import socket

from Sessions import savePoint
from models.Monitor import Monitor


class ICMP:
    def __init__(self, monitor: Monitor):
        self.monitor = monitor
        pass

    def check(self):
        try:
            # Création d'une liste pour stocker les temps de réponse
            rtt_list = []

            # Envoi du paquet ICMP echo request et enregistrement du temps de départ
            packet = scapy.IP(dst=self.monitor.host) / scapy.ICMP()
            t0 = time.perf_counter()

            # Réception de la réponse ICMP echo reply
            reply = scapy.sr1(packet, timeout=self.monitor.timeout, verbose=False)

            rtt = (reply.time - packet.sent_time) * 1000

            if reply:

                response_ip = reply[scapy.IP].src
                if response_ip == socket.gethostbyname(self.monitor.host):
                    # Calcul du temps de réponse en millisecondes


                    current_time = datetime.utcnow().strftime('%Y-%m-%dT%H:%M:%SZ')
                    savePoint({
                        "measurement": "latency",  # Nom de la mesure
                        "tags": {"device_id": self.monitor.device_id},  # Tags (facultatif)
                        "time": current_time,  # Horodatage au format ISO 8601
                        "fields": {"value": rtt}  # Champs de données
                    })


                    return rtt
                else:
                    return -1
            else:
                return -1

        except KeyboardInterrupt:
            return -1
        except Exception as e:
            return -1
