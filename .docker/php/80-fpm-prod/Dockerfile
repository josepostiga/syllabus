FROM php:8.0-fpm

LABEL description="Syllabus production PHP 8.0 image"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

SHELL ["/bin/bash", "-o", "pipefail", "-c"]

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales \
    && cp /usr/share/i18n/SUPPORTED /etc/locale.gen && locale-gen \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libmcrypt-dev \
        libzip-dev \
        libssl-dev \
        libpq-dev \
        openssh-client \
        unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    bcmath \
    pcntl \
    pdo_pgsql \
    pgsql \
    zip

RUN pecl channel-update pecl.php.net \
    && printf "\n" | pecl install mcrypt-1.0.4 \
    && printf "\n" | pecl upgrade timezonedb-2021.1 \
    && printf "\n" | pecl install redis-5.3.4

RUN docker-php-ext-enable \
    mcrypt \
    opcache \
    redis \
    timezonedb

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
