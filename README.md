# Eloquent Serialized LOB

[![Latest Stable Version](https://poser.pugx.org/ngmy/eloquent-serialized-lob/v/stable)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![Total Downloads](https://poser.pugx.org/ngmy/eloquent-serialized-lob/downloads)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![Latest Unstable Version](https://poser.pugx.org/ngmy/eloquent-serialized-lob/v/unstable)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)
[![License](https://poser.pugx.org/ngmy/eloquent-serialized-lob/license)](https://packagist.org/packages/ngmy/eloquent-serialized-lob)

[![Build Status](https://travis-ci.org/ngmy/eloquent-serialized-lob.svg?branch=master)](https://travis-ci.org/ngmy/eloquent-serialized-lob)
[![Coverage Status](https://coveralls.io/repos/ngmy/eloquent-serialized-lob/badge.svg?branch=master)](https://coveralls.io/r/ngmy/eloquent-serialized-lob?branch=master)

Eloquent Serialized LOB is a trait for Laravel 5 Eloquent models that allows [Serialized LOB pattern](http://martinfowler.com/eaaCatalog/serializedLOB.html).

## Installation

1. Install the package by using the Composer:

 ```bash
 composer require ngmy/eloquent-serialized-lob
 ```

2. Add the service provider of the package to the list of service providers in the `config/app.php` file:

 ```php
 'providers' => [
     //...
     'Ngmy\EloquentSerializedLob\SerializedLobTraitServiceProvider',
 ],
 ```

## Usage

**WIP:** See [tests](/tests).

## License

Eloquent Serialized LOB is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
