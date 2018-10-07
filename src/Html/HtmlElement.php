<?php

namespace BeyondCode\TagHelper\Html;

use simplehtmldom_1_5\simple_html_dom_node;

class HtmlElement
{
    /** @var simple_html_dom_node */
    protected $domNode;

    public static function create(simple_html_dom_node $node)
    {
        return new static($node);
    }

    public function __construct(simple_html_dom_node $domNode)
    {
        $this->domNode = $domNode;
    }

    public function hasAttribute(string $attribute): bool
    {
        return $this->domNode->hasAttribute($attribute);
    }

    public function getAttribute(string $attribute, $default = null)
    {
        $attribute = $this->domNode->getAttribute($attribute);

        return $attribute === false ? $default : $attribute;
    }

    public function getAttributeForBlade(string $attribute, $default = null)
    {
        if ($this->domNode->hasAttribute(':'.$attribute)) {
            return $this->getAttribute(':'.$attribute, $default);
        }
        $attribute = $this->domNode->getAttribute($attribute);

        return $attribute === false ? $default : "'".$attribute."'";
    }

    public function setAttribute(string $attribute, string $value)
    {
        $this->domNode->setAttribute($attribute, $value);
    }

    public function removeAttribute(string $attribute)
    {
        $this->domNode->setAttribute($attribute, null);
        $this->domNode->setAttribute(':'.$attribute, null);
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
