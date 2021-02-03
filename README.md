# test-data-generator

[![Latest Version](https://img.shields.io/github/v/release/floor9design-ltd/test-data-generator?include_prereleases&style=plastic)](https://github.com/floor9design-ltd/test-data-generator/releases)
[![Packagist](https://img.shields.io/packagist/v/floor9design/test-data-generator?style=plastic)](https://packagist.org/packages/floor9design/test-data-generator)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=plastic)](LICENCE.md)

[![Build Status](https://img.shields.io/travis/floor9design-ltd/test-data-generator?style=plastic)](https://travis-ci.com/github/floor9design-ltd/test-data-generator)
[![Build Status](https://img.shields.io/codecov/c/github/floor9design-ltd/test-data-generator?style=plastic)](https://codecov.io/gh/floor9design-ltd/test-data-generator)

[![Github Downloads](https://img.shields.io/github/downloads/floor9design-ltd/test-data-generator/total?style=plastic)](https://github.com/floor9design-ltd/test-data-generator)
[![Packagist Downloads](https://img.shields.io/packagist/dt/floor9design/test-data-generator?style=plastic)](https://packagist.org/packages/floor9design/test-data-generator)


## Introduction

This offers a very simple class offering methods for basic data generation, ideal for unit tests or data filling.
This is not meant to be an ongoing replacement for [fzaninotto/Faker](https://github.com/fzaninotto/Faker), but bear in 
mind that it is [Faker is retired](https://marmelab.com/blog/2020/10/21/sunsetting-faker.html).

Some of the included functions are very simple, but the small amounts of code, such as filtering or formatting add up 
to a lot of duplication. In fact, this is the reason the package came about. It simply centralises this code, allowing
a single point to catch all this nuance. 

For example; it is simple to create a random date string, however there are several traps for random generation. MySQL 
date strings have bounds (after 1000-01-01), MySQL dates are padded with zeros (February is 02, not 2) and so on and so 
forth. By using this class these complexities are centralised and resolved in a well tested class structure.

Core functions are exposed, but there are also numerous quick aliases ready for use. For example, 
The core `randomMySqlDateTimeTimestamp` offers a safe bounded and correctly instantiated timestamp, which allows a safe 
call for `randomMySqlDate` and `randomMySqlDateTime`. 

To be clear; the above example methods are simple, predefined lookups. They are simply just conveniently set-up 
methods. However, the methods are designed to allow custom output criteria. A formatted date output can easily be 
generated as well, such as `randomMySqlDate('l jS \of F Y h:i:s A')`. All relevant/appropriate methods do this also.

## Features

* simple response
* efficient installation

## Install

Via Composer

``` bash
composer require floor9design/test-data-generator
```

## Usage

* [Usage](docs/project/usage.md)

## Setup

These are a simple classes, so minimal setup is required. In a composer/PSR compliant system, this should be
automatically included. If your system works another way, this can be manually included.

Note that they are namespaced, so should not clash with your other classes/methods.

## Testing

To run the tests: 

* `./vendor/phpunit/phpunit/phpunit`

Documentation and coverage can be generated as follows:

* `./vendor/phpunit/phpunit/phpunit --coverage-html docs/tests/`

## Credits

- [Rick](https://github.com/elb98rm)

## Changelog

A changelog is generated here:

* [Change log](CHANGELOG.md)

## License

* [MIT](LICENCE.md)