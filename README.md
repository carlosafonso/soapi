# soapi

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

An enhanced, drop-in replacement of PHP's SOAP library.

PHP's native SOAP library will do the trick most of the time, but it falls somewhat short when you need to do complex stuff with your SOAP flow, such as implementing WSSE or doing some logging. This library is a drop-in replacement that allows defining custom pipelines for manipulating and working with requests and responses. Additional improvements, such as better error handling, are on the works.

## Install

Via Composer

``` bash
$ composer require carlosafonso/soapi
```

## Usage

(TBC)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email the author instead of using the issue tracker.

## Credits

- [Carlos Afonso][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/carlosafonso/soapi.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/carlosafonso/soapi/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/carlosafonso/soapi.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/carlosafonso/soapi.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/carlosafonso/soapi.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/carlosafonso/soapi
[link-travis]: https://travis-ci.org/carlosafonso/soapi
[link-scrutinizer]: https://scrutinizer-ci.com/g/carlosafonso/soapi/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/carlosafonso/soapi
[link-downloads]: https://packagist.org/packages/carlosafonso/soapi
[link-author]: https://github.com/carlosafonso
[link-contributors]: ../../contributors
