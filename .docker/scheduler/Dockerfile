FROM ghcr.io/josepostiga/syllabus/php

LABEL description="Syllabus scheduler PHP 8.0 image"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

RUN touch /var/log/cron.log

RUN apt-get update \
    && apt-get install -y --no-install-recommends cron vim \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
