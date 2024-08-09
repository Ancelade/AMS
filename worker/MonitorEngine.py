class MonitorEngine:
    def __init__(self):
        self.monitors = []
        self.thread = []
        pass

    def reset(self):
        for monitor in self.monitors:
            monitor.stop()

        self.monitors = []
        pass

    def add(self, monitor):
        monitor.start()
        self.monitors.append(monitor)
        pass
