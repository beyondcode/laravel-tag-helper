<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class LinkHelper extends Helper
{
    protected $targetElement = 'a';

    protected $targetAttribute = 'route';

    public function process(HtmlElement $element)
    {
        $element->setTag('a');

        $element->href = '{{route('.$element->getAttributeForBlade('route').', '.$element->getAttributeForBlade('route-parameters', '[]'). ')}}';

        $element->removeAttribute('route');
        $element->removeAttribute('route-parameters');
    }
}
