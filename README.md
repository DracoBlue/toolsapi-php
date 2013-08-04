# ToolsApi PHP Client

* Version: 1.x-dev
* Date: not-yet-released
* Build Status: [![Build Status](https://secure.travis-ci.org/DracoBlue/toolsapi-php.png?branch=master)](http://travis-ci.org/DracoBlue/toolsapi-php)

This is the official php client implementation of [toolsapi.com](http://toolsapi.com). It implements the latest [toolsapi http protocol](http://toolsapi.local/toolsapi-http-protocol).

## Installation Git Version

Clone the repository and enter the directory

    $ git clone git@github.com:DracoBlue/toolsapi-php.git
    $ cd toolsapi-php

Install dependencies with composer

    $ make install-dependencies

Create a toolsapi.properties in either your `$HOME`-directory or as `/etc/toolsapi.properties`

    url=http://toolsapi.com/
    user=tester
    password=password

## Run Tests

    $ make test

## Changelog

- 1.x-dev
  - initial version 

## License

This work is copyright by DracoBlue (<http://dracoblue.net>) and not licensed under any license, yet.