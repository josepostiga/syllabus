#!/usr/bin/env bash
docker build 80-fpm-prod -t ghcr.io/josepostiga/syllabus/php
docker build 80-fpm-dev -t ghcr.io/josepostiga/syllabus/php:dev
docker build 80-fpm-cov -t ghcr.io/josepostiga/syllabus/php:cov
