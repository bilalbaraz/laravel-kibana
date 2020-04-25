# Laravel Kibana

![Packagist Version](https://img.shields.io/packagist/v/bilalbaraz/laravel-kibana)
![Packagist](https://img.shields.io/packagist/l/bilalbaraz/laravel-kibana)
[![Build Status](https://travis-ci.org/bilalbaraz/laravel-kibana.svg?branch=master)](https://travis-ci.org/bilalbaraz/laravel-kibana)
[![codecov](https://codecov.io/gh/bilalbaraz/laravel-kibana/branch/master/graph/badge.svg)](https://codecov.io/gh/bilalbaraz/laravel-kibana)

T.B.D.

## Installation and Configuration
Install the current version of the `bilalbaraz/laravel-kibana package via composer:

```bash
composer require bilalbaraz/laravel-kibana
```

The package's service provider will automatically register its service provider.

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Bilalbaraz\LaravelKibana\KibanaServiceProvider"
```

After you publish the configuration file as suggested above, you may configure Kibana by adding the following to your application's `.env` file (with appropriate values):

```ini
KIBANA_VERSION=7.6.2
KIBANA_HOST=127.0.0.1
KIBANA_PORT=5601
```

### Usage

T.B.D.

## Documentation

Have a look at the documentation [here](https://bilalbaraz.github.io/laravel-kibana/).

## Test

```bash
./vendor/bin/phpunit tests
```

## Which Endpoints Have Been Implemented?

- [x] Get features
- [x] Create space
- [x] Update space
- [x] Get space
- [x] Get all spaces
- [x] Delete space
- [ ] Copy saved objects to space
- [ ] Resolve copy to space conflicts
- [ ] Create or update role
- [ ] Get specific role
- [ ] Get all roles
- [ ] Delete role
- [x] Get object
- [x] Bulk get objects
- [x] Find objects
- [ ] Create saved objects
- [ ] Bulk create saved objects
- [ ] Update object
- [x] Delete object
- [x] Export objects
- [ ] Resolve import errors
- [x] Import dashboard
- [x] Export dashboard

## Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via pull requests via 
[Github](https://github.com/bilalbaraz/laravel-kibana).

1. Fork the project.
2. Create your bugfix/feature branch and write your (well-commented) code.
3. Create unit tests for your code:
	- Run `composer install --dev` in the root directory to install required testing packages.
	- Add your test classes/methods to the `/tests/` directory.
	- Run `vendor/bin/phpunit` and make sure everything passes (new and old tests).
3. Commit your changes (and your tests) and push to your branch.
4. Create a new pull request against this package's `master` branch.

## Copyright and License

[laravel-kibana](https://github.com/bilalbaraz/laravel-kibana)
was written by [Bilal Baraz](https://github.com/bilalbaraz) and is released under the 
[MIT License](LICENSE.md).
