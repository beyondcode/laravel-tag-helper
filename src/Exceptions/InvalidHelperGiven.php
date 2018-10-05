<?php

namespace BeyondCode\TagHelper\Exceptions;


class InvalidHelperGiven extends \Exception
{

    public static function withHelper(string $helper)
    {
        return new static('Invalid helper class '.$helper);
    }

}