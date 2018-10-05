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

You can create your own Tag Helper, by creating a new class and extend from the `BeyondCode\TagHelper\Helper` class.
Within this class you can define on which HTML elements and attributes your helper should be triggered:

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomTagHelper extends Helper
{
    protected $targetAttribute = 'custom';

    protected $targetElement = 'div';

    public function process(HtmlElement $element)
    {
        // Manipulate the DOM element
    }
}

```

To use and apply this tag helper, you need to register it. Typically you would do this in the `AppServiceProvider boot()` method or a service provider of your own.

```php
TagHelper::helper(CustomTagHelper::class);
```

Since you only register the class name of the custom tag helper, you can use dependency injection inside of your custom helper class.

### Binding your helper to HTML elements and attributes

In your custom tag helper, you can use the `$targetAttribute` and `$targetElement` properties to specify which HTML element (`div`, `form`, `a`, etc.) and which attributes (`<div custom="value />`, `<form method="post">`, etc.) you want to bind this helper to.

If you do not provide a `targetElement` on your own, this package will use a `*` as a wildcard in order to target **all** elements with a specific attribute, like this:

```php
class CustomTagHelper extends Helper
{
    protected $targetAttribute = 'my-attribute';
    
    // ...
    
}
```

This tag helper would be called for every HTML element that has a `my-attribute` attribute.

### Manipulating DOM Elements

## Built-In Helpers


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
