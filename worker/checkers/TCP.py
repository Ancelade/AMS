import socket
import time

from models.Monitor import Monitor


class TCP:
    def __init__(self, monitor: Monitor):
        self.monitor = monitor
        pass

    def check(self):
        try:
            start_time = time.time()
            # Crée une socket TCP
            with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
                # Configure un délai d'attente (en secondes) pour la tentative de connexion
                sock.settimeout(self.monitor.timeout)

                # Tente de se connecter au port
                sock.connect((self.monitor.host, self.monitor.port))

            end_time = time.time()

            return (end_time - start_time) * 1000
        except (socket.timeout, ConnectionRefusedError):
            # Si la connexion échoue (délai d'attente dépassé ou connexion refusée), le port est fermé
            return -1
        except Exception as e:
            return -1
