<?php

namespace BeyondCode\TagHelper\Helpers;


use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class LinkHelper extends Helper
{

    protected $targetElement = 'route-link';

    protected $targetAttribute = null;

    public function process(HtmlElement $element)
    {
        $element->setTag('a');

        $element->href = route($element->getAttribute('to'), $element->getAttribute('route-parameters'));

        $element->removeAttribute('route');
        $element->removeAttribute('route-parameters');
    }
}