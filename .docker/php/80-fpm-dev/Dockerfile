FROM ghcr.io/josepostiga/syllabus/php

LABEL description="Syllabus development PHP 8.0 image (alpine)"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

RUN pecl install xdebug-3.0.4 && \
  docker-php-ext-enable xdebug

ENV COMPOSER_HOME /tmp/composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV GIT_SSH_COMMAND "ssh -o StrictHostKeyChecking=no"
