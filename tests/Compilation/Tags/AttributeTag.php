<?php

namespace BeyondCode\TagHelper\Tests\Compilation\Tags;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class AttributeTag extends Helper
{
    protected $targetAttribute = 'custom-helper';

    public function process(HtmlElement $element)
    {
        $element->appendInnerText('Processed');
        $element->removeAttribute('custom-helper');
    }
}