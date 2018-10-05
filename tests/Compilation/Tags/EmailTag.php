<?php

namespace BeyondCode\TagHelper\Tests\Compilation\Tags;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class EmailTag extends Helper
{
    protected $targetElement = 'custom-email';

    public function process(HtmlElement $element)
    {
        $element->setTag('div');
        $element->prependInnerText('This is a custom email tag helper.');
    }
}