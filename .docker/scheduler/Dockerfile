FROM ghcr.io/josepostiga/syllabus/php

LABEL description="Syllabus scheduler PHP 8.0 image"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

RUN touch /var/log/cron.log

RUN apk --no-cache add cronie vim
