<?php

namespace BeyondCode\TagHelper\Html;

use simplehtmldom_1_5\simple_html_dom_node;
use BeyondCode\TagHelper\Exceptions\InvalidTagAttribute;

class HtmlElement
{
    /** @var simple_html_dom_node */
    protected $domNode;

    /** @var array */
    protected $viewData;

    public static function create(simple_html_dom_node $node, array $viewData)
    {
        return new static($node, $viewData);
    }

    public function __construct(simple_html_dom_node $domNode, array $viewData)
    {
        $this->domNode = $domNode;
        $this->viewData = $viewData;
    }

    public function hasAttribute(string $attribute): bool
    {
        return $this->domNode->hasAttribute($attribute);
    }

    protected function getParsedAttribute(string $attributeValue)
    {
        try {
            extract($this->viewData, EXTR_SKIP);
            $result = eval('return '.$attributeValue.';');
        } catch (\Throwable $e) {
            throw InvalidTagAttribute::withAttribute($attributeValue);
        }

        return $result;
    }

    public function getAttribute(string $attribute, $default = null)
    {
        if ($this->domNode->hasAttribute(':'.$attribute)) {
            $attribute = $this->getParsedAttribute($this->domNode->getAttribute(':'.$attribute));
        } else {
            $attribute = $this->domNode->getAttribute($attribute);
        }

        return $attribute === false ? $default : $attribute;
    }

    public function setAttribute(string $attribute, string $value)
    {
        $this->domNode->setAttribute($attribute, $value);
    }

    public function removeAttribute(string $attribute)
    {
        if ($this->domNode->hasAttribute(':'.$attribute)) {
            $this->domNode->setAttribute(':'.$attribute, null);
        }
        $this->domNode->setAttribute($attribute, null);
    }

    public function getInnerText(): string
    {
        return $this->domNode->innertext();
    }

    public function setInnerText(string $text)
    {
        $this->domNode->innertext = $text;
    }

    public function getPlainText(): string
    {
        return $this->domNode->text();
    }

    public function prependInnerText(string $prepend)
    {
        $this->setInnerText($prepend.$this->getInnerText());
    }

    public function appendInnerText(string $append)
    {
        $this->setInnerText($this->getInnerText().$append);
    }

    public function getOuterText(): string
    {
        return $this->domNode->outertext();
    }

    public function setOuterText(string $text)
    {
        $this->domNode->outertext = $text;
    }

    public function setTag(string $tag)
    {
        $this->domNode->tag = $tag;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->domNode, $method], $args);
    }

    public function __get($key)
    {
        return $this->domNode->$key;
    }

    public function __set($key, $val)
    {
        return $this->domNode->$key = $val;
    }
}
