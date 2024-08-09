# AMS
ANCEADE MONITORING SYSTEM

Originally, this project was developed internally and was not intended to be made public. However, after careful consideration, we decided to release it to the public.

This project is a monitoring system. Currently, it primarily provides basic uptime monitoring services, but in the future, we plan to make this software much more comprehensive, so it can become a viable and ergonomic alternative to LibreNMS, Observium, Zabbix, or even SaaS tools like Datadog or New Relic.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Features](#features)
- [Contribution](#contribution)
- [License](#license)
- [Contact](#contact)

## Installation

### With Docker Compose

```bash
# Clone the repo
git clone https://github.com/Ancelade/AMS.git

# Navigate to the directory
cd AMS

# Install dependencies
docker compose up
```

### Using the public image
```bash
docker volume create ams_data

docker run -d --name ams_container -v appdata_volume:/appdata -p 80:80 ancelade/ams:latest
```

## Features

### Currently
- ICMP monitoring
- Web app monitoring via HTTP
- Application monitoring via TCP Port
- Basic SNMP collection (Pre-Alpha)

#### A few screenshots
--Coming soon--

### In the future
- Full SNMP collection
- Installable agent monitoring on Linux and Windows
- Monitoring via SSH
- Application monitoring
- REST API
- Dashboard system
- Traffic billing management
- Interactive JS Weathermap
- Addition of other notification systems
-  ... ...

## Contribution

1. Fork the project.
2. Create a branch for your feature (`git checkout -b feature/FeatureName`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature/FeatureName`).
5. Open a Pull Request.

Please make unit fixes and avoid submitting large, incomprehensible patches.

## License

This project is provided under a private rights license (see: license.txt).

## Contact

Marc Moreau - contact@ancelade.com
