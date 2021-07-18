FROM ghcr.io/josepostiga/syllabus/php

LABEL description="Syllabus code coverage PHP 8.0 image"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

SHELL ["/bin/bash", "-o", "pipefail", "-c"]

RUN printf "\n" | pecl install pcov \
    && docker-php-ext-enable pcov

ENV COMPOSER_HOME /tmp/composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
