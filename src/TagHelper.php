<?php

namespace BeyondCode\TagHelper;

use BeyondCode\TagHelper\Exceptions\InvalidHelperGiven;

class TagHelper
{
    /** @var array */
    public $registeredTagHelpers = [];

    public function getRegisteredTagHelpers(): array
    {
        return array_map(function ($helper) {
            return app($helper);
        }, $this->registeredTagHelpers);
    }

    public function helper(string $helper)
    {
        if (! is_subclass_of($helper, Helper::class)) {
            throw InvalidHelperGiven::withHelper($helper);
        }

        $this->registeredTagHelpers[] = $helper;
    }
}
