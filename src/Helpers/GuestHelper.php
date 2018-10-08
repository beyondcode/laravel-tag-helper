<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class GuestHelper extends Helper
{
    protected $targetAttribute = 'guest';

    public function process(HtmlElement $element)
    {
        // Check if an explicit attribute value was specified.
        if ($element->getAttribute('guest') === true) {
            $guest = null;
        } else {
            $guest = $element->getAttributeForBlade('guest');
        }

        $element->removeAttribute('guest');

        $outerText = '@guest('.$guest.') ';
        $outerText .= $element->getOuterText();
        $outerText .= ' @endguest';

        $element->setOuterText($outerText);

    }
}
