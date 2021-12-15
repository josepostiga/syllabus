FROM php:8.0-fpm-alpine

LABEL description="Syllabus production PHP 8.0 image (alpine)"
LABEL org.opencontainers.image.source="https://github.com/josepostiga/syllabus"

# Install language pack
RUN apk --no-cache add ca-certificates wget && \
    wget -q -O /etc/apk/keys/sgerrand.rsa.pub https://alpine-pkgs.sgerrand.com/sgerrand.rsa.pub && \
    wget https://github.com/sgerrand/alpine-pkg-glibc/releases/download/2.25-r0/glibc-2.25-r0.apk && \
    wget https://github.com/sgerrand/alpine-pkg-glibc/releases/download/2.25-r0/glibc-bin-2.25-r0.apk && \
    wget https://github.com/sgerrand/alpine-pkg-glibc/releases/download/2.25-r0/glibc-i18n-2.25-r0.apk && \
    apk --no-cache add glibc-bin-2.25-r0.apk glibc-i18n-2.25-r0.apk glibc-2.25-r0.apk

# Iterate through all locale and install it
# Note that locale -a is not available in alpine linux, use `/usr/glibc-compat/bin/locale -a` instead
COPY ./locale.md /locale.md
RUN cat /locale.md | xargs -i /usr/glibc-compat/bin/localedef -i {} -f UTF-8 {}.UTF-8

RUN apk --no-cache add \
    autoconf \
    gcc \
    libmcrypt-dev \
    libpq-dev \
    libssl1.1 \
    libzip-dev \
    make \
    musl-dev \
    openssh-client \
    unzip

RUN docker-php-ext-install \
    bcmath \
    pcntl \
    pdo_pgsql \
    pgsql \
    zip

RUN pecl install mcrypt-1.0.4 && \
    pecl install redis-5.3.4 && \
    pecl upgrade timezonedb-2021.5

RUN docker-php-ext-enable \
    mcrypt \
    opcache \
    redis \
    timezonedb

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
