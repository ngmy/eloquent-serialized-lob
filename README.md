# Eloquent Serialized LOB

[![Latest Stable Version](https://poser.pugx.org/ngmy/eloquent-serialized-lob/v/stable)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![Total Downloads](https://poser.pugx.org/ngmy/eloquent-serialized-lob/downloads)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![Latest Unstable Version](https://poser.pugx.org/ngmy/eloquent-serialized-lob/v/unstable)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![License](https://poser.pugx.org/ngmy/eloquent-serialized-lob/license)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![composer.lock](https://poser.pugx.org/ngmy/eloquent-serialized-lob/composerlock)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)<br>
[![PHP CI](https://github.com/ngmy/eloquent-serialized-lob/workflows/PHP%20CI/badge.svg)](https://github.com/ngmy/eloquent-serialized-lob/actions?query=workflow%3A%22PHP+CI%22)
[![Coverage Status](https://coveralls.io/repos/ngmy/eloquent-serialized-lob/badge.svg?branch=master)](https://coveralls.io/r/ngmy/eloquent-serialized-lob?branch=master)

Eloquent Serialized LOB is a trait for Laravel Eloquent models that allows [Serialized LOB pattern](http://martinfowler.com/eaaCatalog/serializedLOB.html).

## Requirements

Eloquent Serialized LOB has the following requirements:

* PHP >= 7.3
* Laravel >= 6.0

## Installation

1. Execute the Composer `require` command:
   ```console
   composer require ngmy/eloquent-serialized-lob
   ```
2. If you don't use package discovery, add the service provider to the `providers` array in the `config/app.php` file:
   ```php
   Ngmy\EloquentSerializedLob\EloquentSerializedLobServiceProvider::class,
   ```

## Usage

**WIP:** See [tests](/tests).

## License

Eloquent Serialized LOB is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
