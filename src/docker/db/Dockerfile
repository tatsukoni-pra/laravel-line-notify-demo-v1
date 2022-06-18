FROM mysql:8.0

ENV MYSQL_DATABASE=local \
    MYSQL_USER=docker \
    MYSQL_PASSWORD=docker \
    MYSQL_ROOT_PASSWORD=root \
    TZ=Asia/Tokyo

COPY my.cnf /etc/mysql/conf.d/my.cnf

RUN chmod 644 /etc/mysql/conf.d/my.cnf
