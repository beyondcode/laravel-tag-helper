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

Once your tag helper successfully matches one or multiple HTML elements, the `process` method of your tag helper will be called.

Inside of this method, you can manipulate the HTML element.

Available features:

#### Changing the HTML element tag

In this example, we are binding our helper to HTML elements `<my-custom-link href="/"></my-custom-link>`. In the process method, we can then change the tag internally to `a` to render this as a link.

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomLink extends Helper
{
    protected $targetElement = 'my-custom-link';

    public function process(HtmlElement $element)
    {
        $element->setTag('a');
    }
}
```

#### Manipulating Attributes

You can also add, edit or delete HTML element attributes.

In this example, we are binding our helper to all link tags that have a custom `route` attribute.
We then update the `href` attribute of our link, remove the `route` attribute and add a new `title` attribute. 

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomLink extends Helper
{
    protected $targetAttribute = 'route';
    
    protected $targetElement = 'a';

    public function process(HtmlElement $element)
    {
        $element->setAttribute('href', route($element->getAttribute('route')));
        
        $element->removeAttribute('route');
        
        $element->setAttribute('title', 'This is a link.');
    }
}
```

#### Manipulating Outer / Inner Text

Your custom tag helpers can you manipulate the HTML that is inside or outside of the current element. 

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomLink extends Helper
{
    protected $targetAttribute = 'add-hidden-field';
    
    protected $targetElement = 'form';

    public function process(HtmlElement $element)
    {
        $element->removeAttribute('add-hidden-field');
        
        $element->appendInnerText('<input type="hidden" name="hidden" />');
        
        // $element->prependInnerText('');
        // $element->setInnerText('');
    }
}
```

### Passing variables to your tag helpers

You can pass attribute values to your tag helpers  as you would usually pass attributes to HTML elements.
Since the modifications of your tag helpers get cached, you should always return valid Blade template output in your modified attribute values.

You can **not** directly access the variable content inside of your tag helper, but only get the attribute string representation.

For example, to get the attribute value of the `method` attribute:

```html
<form method="post"></form>
```

You can access this data, using the `getAttribute` method inside your helper:

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomForm extends Helper
{
    protected $targetElement = 'form';

    public function process(HtmlElement $element)
    {
        $formMethod = $element->getAttribute('method');
    }
}
```

If you want to write Blade output, you sometimes need to know if the user passed a variable or function call, or a string value.
To tell the difference, users can pass variable data by prefixing the attribute using a colon.

If you want to output this attribute into a blade template, you can then use the `getAttributeForBlade` method and it will 
either give you an escaped string representation of the attribute - or the unescaped representation, in case it got prefixed by a colon.

For example:

```html
<a route="home">Home</a>
```

```php
<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CustomForm extends Helper
{
    protected $targetElement = 'a';

    protected $targetAttribute = 'route';

    public function process(HtmlElement $element)
    {
        $element->setAttribute('href', "{{ route(" . $element->getAttributeForBlade('route') . ") }}");
        
        $element->removeAttribute('route');
    }
}
```

This will output:

```html
<a href="{{ route('home') }}">Home</a>
```

But if you pass a dynamic parameter like this:

```html
<a :route="$routeVariable">Home</a>
```

This will output:

```html
<a href="{{ route($routeVariable) }}">Home</a>
```

This way you do not need to manually care about escaping and detecting dynamic variables.

## Built-In Helpers

This package ships with a couple useful tag helpers out of the box.

### CSRF Helper

Just add a `csrf` attribute to any `form` element to automatically add the Laravel CSRF field to it.

```html
<form method="post">

</form>
```

Will become:


```html
<form csrf method="post">
    <input type="hidden" name="_token" value="csrf-token">    
</form>
```

### Form Method Helper

When your `form` contains a `method` other then `GET` or `POST`, the helper will automatically add a `_method` hidden field with the correct value to your form.

```html
<form method="delete">

</form>
```

Will become:


```html
<form method="post">
    <input type="hidden" name="_method" value="DELETE">    
</form>
```

### Link

When your `a` tags contains a `route` attribute, this helper will change the href to the appropriate route.
You can also provide a `route-parameters` attribute, to pass additional parameters to the route generation.

Examples:
```html
<a route="home">Home</a>

<a route="profile" route-parameters="[$user->id()]">Home</a>

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
