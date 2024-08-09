# Utilisez l'image PHP 8.1 officielle avec Apache
FROM alpine:3.19.1

RUN apk update

RUN apk update && apk upgrade && \
    apk add --no-cache mariadb mariadb-client supervisor nginx python3 py3-pip php83 php83-snmp php83-fpm php83-opcache php83-session php83-mbstring php83-json php83-openssl php83-curl php83-xml php83-dom php83-zip php83-pdo php83-pdo_mysql php83-tokenizer php83-fileinfo php83-ctype php83-iconv php83-simplexml php83-pdo_sqlite php83-tokenizer php83-xmlwriter php83-xmlreader

RUN echo "http://dl-cdn.alpinelinux.org/alpine/v3.14/community" >> /etc/apk/repositories

RUN apk update

RUN apk add influxdb

RUN mkdir /var/run/php-fpm83/
RUN mkdir /var/run/mysqld/
RUN mkdir /app
RUN mkdir /app_data
RUN mkdir /app_data/influx
RUN mkdir /app_data/influx/meta
RUN mkdir /app_data/influx/tsm
RUN mkdir /app_data/influx/data



COPY . /app

COPY ./docker/my.cnf /etc/my.cnf
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/php.ini /etc/php83/php.ini
COPY ./docker/php-fpm.conf /etc/php83/php-fpm.conf
COPY ./docker/influxdb.conf /etc/influxdb.conf
COPY ./docker/supervisord.conf /etc/supervisord.conf

RUN chmod 777 -Rf /app
RUN chmod 777 -Rf /var/run/php-fpm83/
RUN chmod 777 -Rf /var/run/mysqld/

RUN cd /app/worker/ && pip install -r requirements.txt --break-system-packages
RUN mysql_install_db  --datadir=/app_data/mysql

RUN chmod 777 -Rf /app_data

WORKDIR /app

ENTRYPOINT ["sh", "-c", "supervisord -n -c /etc/supervisord.conf"]


