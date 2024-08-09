import logging
import time

logging.getLogger("urllib3.connectionpool").setLevel(logging.CRITICAL)
import requests

from models.Monitor import Monitor


class HTTPS:
    def __init__(self, monitor: Monitor):
        self.monitor = monitor

        pass

    def check(self):
        try:
            start_time = time.time()
            response = requests.get(self.monitor.host, timeout=self.monitor.timeout, verify=False)
            website_source_code = response.text
            if self.monitor.keyword is not None and self.monitor.keyword != "":
                if self.monitor.keyword in website_source_code:
                    end_time = time.time()
                    return (end_time - start_time) * 1000
                else:
                    return -1
            else:
                end_time = time.time()
                return (end_time - start_time) * 1000
        except Exception as  e:
            print(e)
            return -1
