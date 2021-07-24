> This project is still in active development!

# Syllabus

A School Management System built with students, parents, and teachers, in mind.

![Run tests](https://github.com/josepostiga/syllabus/workflows/Run%20tests/badge.svg)
[![Coverage Status](https://coveralls.io/repos/github/josepostiga/syllabus/badge.svg?branch=main)](https://coveralls.io/github/josepostiga/syllabus?branch=main)

## Installation

The following installation steps requires Docker and Docker-Compose to be installed in your system. 

1. Clone this repository.
1. Run `.bin/composer.sh install`
1. Run `.bin/php.sh artisan key:generate`
1. Duplicate `docker-compose.override-example.yaml` and rename it `docker-compose.override.yaml`
1. If you already have a webserver (like Apache, NGINX, or other), simply route the traffic to the project's `web-server` container. If not, you can edit the `docker-compose.override.yaml` file and add the necessary ports mapping to bind your host's ports to the container's.
1. Run `docker-compose up -d`
1. Run `.bin/php.sh artisan migrate`

If you have any problems, refer to the [Discussions Support category](https://github.com/josepostiga/syllabus/discussions/categories/support) to ask for help.

## Testing

This project is fully tested. We have an [automatic pipeline](https://github.com/josepostiga/syllabus/actions) and an [automatic code quality analysis](https://coveralls.io/github/josepostiga/syllabus) tool set up to continuously test and assert the quality of all code published in this repository, but you can execute the test suite yourself by running the following command:

``` bash
.bin/php.sh vendor/bin/phpunit
```

_Note: This assumes you've run `.bin/composer.sh install` (without the `--no-dev` option)._

**We aim to keep the main branch always deployable.** Exceptions may happen, but they should be extremely rare.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

Please see [SECURITY](SECURITY.md) for details.

## Credits

- [José Postiga](https://github.com/josepostiga)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
