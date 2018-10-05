<?php

namespace BeyondCode\TagHelper\Exceptions;


class InvalidTagAttribute extends \Exception
{

    public static function withAttribute(string $attribute)
    {
        return new static('The tag helper attribute value could not be parsed: '.$attribute);
    }

}