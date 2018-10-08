<?php

namespace BeyondCode\TagHelper\Helpers;

use BeyondCode\TagHelper\Helper;
use BeyondCode\TagHelper\Html\HtmlElement;

class ConditionHelper extends Helper
{
    protected $targetAttribute = 'if';

    public function process(HtmlElement $element)
    {
        $condition = $element->getAttribute('if');

        $element->removeAttribute('if');

        $outerText = '@if('.$condition.') ';
        $outerText .= $element->getOuterText();
        $outerText .= ' @endif';

        $element->setOuterText($outerText);
    }
}
