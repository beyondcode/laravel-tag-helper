<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class FormMethodHelper extends Helper
{
    protected $targetAttribute = 'method';

    protected $targetElement = 'form';

    public function process(HtmlElement $element)
    {
        $method = strtolower($element->getAttribute('method'));

        if ($method !== 'get' && $method !== 'post') {
            $element->setAttribute('method', 'post');
            $element->appendInnerText('<input type="hidden" name="_method" value="'.strtoupper($method).'" />');
        }
    }
}
