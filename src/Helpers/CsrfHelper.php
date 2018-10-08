<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class CsrfHelper extends Helper
{
    protected $targetAttribute = 'csrf';

    protected $targetElement = 'form';

    public function process(HtmlElement $element)
    {
        $element->removeAttribute('csrf');

        $element->appendInnerText('@csrf');
    }
}
