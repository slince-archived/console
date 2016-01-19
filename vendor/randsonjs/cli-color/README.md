# PHP Command Line Colors

[![Build Status](https://travis-ci.org/randsonjs/cli-color.svg?branch=master)](https://travis-ci.org/randsonjs/cli-color)

Just another colors and formatting for the console solution

## Dependencies

1. Install [PHP](http://php.net/downloads) if you don't have it yet.
2. Install [Composer](http://getcomposer.org) if you don't have it yet.

## Usage

## Installation

The recommended way to install this package is through [composer](http://getcomposer.org).

Create a `composer.json` file.

```json
{
    "minimum-stability": "dev",
    "require": {
        "randsonjs/cli-color": "*"
    }
}
```

Run command to install it.

```sh
$ composer install
```

## File Structure

```
.
|-- src/
|-- tests/
|-- .editorconfig
|-- .gitignore
|-- composer.json
```

#### [src/](src/)

The main files of package, in this directory you will find the [Inflect](https://github.com/randsonjs/inflect/blob/master/src/Inflect/Inflect.php) class.

#### [tests/](tests/)

The tests directory for [Inflect](https://github.com/randsonjs/inflect/blob/master/src/Inflect/Inflect.php) class. Tests are made using [PHPUnit](https://phpunit.de/).

#### [.editorconfig](.editorconfig)

This file is for unifying the coding style for different editors and IDEs.
> Check [editorconfig.org](http://editorconfig.org/) if you haven't heard about this project.

#### [.gitignore](.gitignore)

List of files that we don't want Git to track.
> Check this [Git Ignoring Files Guide](https://help.github.com/articles/ignoring-files) for more details.

#### [composer.json](composer.json)

Specify all dependencies loaded via Composer.
> Check [composer.json](https://getcomposer.org/doc/01-basic-usage.md#composer-json-project-setup) Project Setup for more details.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## License
[MIT License](./LICENSE) © Randson Oliveira
