<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class AuthHelper extends Helper
{
    protected $targetAttribute = 'auth';

    public function process(HtmlElement $element)
    {
        // Check if an explicit attribute value was specified.
        if ($element->getAttribute('auth') === true) {
            $auth = null;
        } else {
            $auth = $element->getAttributeForBlade('auth');
        }

        $element->removeAttribute('auth');

        $outerText = '@auth('.$auth.') ';
        $outerText .= $element->getOuterText();
        $outerText .= ' @endauth';

        $element->setOuterText($outerText);

    }
}
