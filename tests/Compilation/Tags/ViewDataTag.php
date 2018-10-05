<?php

namespace BeyondCode\TagHelper\Tests\Compilation\Tags;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class ViewDataTag extends Helper
{
    protected $targetElement = 'div';

    protected $targetAttribute = 'view-data';

    public function process(HtmlElement $element)
    {
        $element->appendInnerText($element->getAttribute('view-data'));
        $element->removeAttribute('view-data');
    }
}