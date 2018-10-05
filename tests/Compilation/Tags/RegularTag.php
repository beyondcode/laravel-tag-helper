<?php

namespace BeyondCode\TagHelper\Tests\Compilation\Tags;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class RegularTag extends Helper
{
    protected $targetElement = 'div';

    protected $targetAttribute = 'custom-helper';

    public function process(HtmlElement $element)
    {
        $element->appendInnerText('Processed');
        $element->removeAttribute('custom-helper');
    }
}