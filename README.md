## adhocore/plastic

PHP elasticsearch wrapper designed to be minimal, intuitive and dependency free.

[![Latest Version](https://img.shields.io/github/release/adhocore/plastic.svg?style=flat-square)](https://github.com/adhocore/plastic/releases)
[![Travis Build](https://img.shields.io/travis/com/adhocore/plastic.svg?branch=master&style=flat-square)](https://travis-ci.com/adhocore/plastic?branch=master)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/adhocore/plastic.svg?style=flat-square)](https://scrutinizer-ci.com/g/adhocore/plastic/?branch=master)
[![Codecov branch](https://img.shields.io/codecov/c/github/adhocore/plastic/master.svg?style=flat-square)](https://codecov.io/gh/adhocore/plastic)
[![StyleCI](https://styleci.io/repos/{styleci}/shield)](https://styleci.io/repos/{styleci})
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](./LICENSE)


## Installation
```bash
composer require adhocore/plastic
```

## Usage

```php
use Ahc\Plastic\Client;

# Instantiate:
$client = new Ahc\Plastic\Client(null, true);

# Usage convention:
$client->{$httpMethod}->$segment1->$segment2->$method($data);

# For numeric segment or method, prepend with `_`.

# Example:
$client->post->articles->article->_1(['key' => 'value']);
```

See [./test.php](./test.php) for more.

## API

<!-- DOCS START -->
<!-- DOCS END -->

## Contributing

Please check [the guide](./CONTRIBUTING.md)

## LICENSE

> &copy; [MIT](./LICENSE) | 2019, Jitendra Adhikari
