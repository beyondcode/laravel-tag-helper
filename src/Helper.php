<?php

namespace BeyondCode\TagHelper;

use BeyondCode\TagHelper\Html\HtmlElement;

abstract class Helper
{
    /** @var string */
    protected $targetElement = '*';

    /** @var string */
    protected $targetAttribute = null;

    public function getTargetElement(): string
    {
        return $this->targetElement;
    }

    public function getTargetAttribute(): ?string
    {
        return $this->targetAttribute;
    }

    abstract public function process(HtmlElement $element);
}
