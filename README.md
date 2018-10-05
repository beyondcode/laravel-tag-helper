# Laravel Tag Helpers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-tag-helper.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-tag-helper)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-tag-helper/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-tag-helper)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-tag-helper.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-tag-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-tag-helper.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-tag-helper)

This package allows you to register custom "tag helpers" in your Laravel application. These helpers can modify the HTML code.

For example, instead of this:

```html
<form csrf method="delete">

</form> 
```

You can use custom tag helpers to turn this code into this:

```html
<form method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="csrf-token">    
</form>
```

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-tag-helper
```

The package will automatically register itself.

## Usage

``` php
$skeleton = new BeyondCode\TagHelper();
echo $skeleton->echoPhrase('Hello, BeyondCode!');
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marcel@beyondco.de instead of using the issue tracker.

## Credits

- [Marcel Pociot](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
