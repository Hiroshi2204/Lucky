FROM mysql:8.0

RUN microdnf install -y gzip curl unzip \
    && microdnf clean all

RUN curl https://rclone.org/install.sh | bash

WORKDIR /backup

COPY backup.sh /backup/backup.sh

RUN chmod +x /backup/backup.sh

CMD ["/backup/backup.sh"]