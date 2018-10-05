<?php

namespace BeyondCode\TagHelper\Facades;

use Illuminate\Support\Facades\Facade;

class TagHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tag-helper';
    }
}
