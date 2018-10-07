<?php

namespace BeyondCode\TagHelper;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Filesystem\Filesystem;
use BeyondCode\TagHelper\Html\HtmlElement;

class TagHelperCompiler
{
    /** @var TagHelper */
    protected $tagHelper;

    /** @var Filesystem */
    protected $files;

    public function __construct(TagHelper $tagHelper, Filesystem $files)
    {
        $this->tagHelper = $tagHelper;
        $this->files = $files;
    }

    public function needsToBeRecompiled($path, $compiled)
    {
        if (! $this->files->exists($compiled)) {
            return true;
        }

        return $this->files->lastModified($path) >=
            $this->files->lastModified($compiled);
    }

    public function compile(string $viewContent)
    {
        return array_reduce(
            $this->tagHelper->getRegisteredTagHelpers(),
            [$this, 'parseHtml'],
            $viewContent
        );
    }

    protected function getTagSelector(Helper $tagHelper): string
    {
        $selector = $tagHelper->getTargetElement();
        if (! is_null($tagHelper->getTargetAttribute())) {
            $selector .= "[{$tagHelper->getTargetAttribute()}]";
            $selector .= ", {$tagHelper->getTargetElement()}[:{$tagHelper->getTargetAttribute()}]";
        }

        return $selector;
    }

    protected function parseHtml(string $viewContents, Helper $tagHelper)
    {
        $html = HtmlDomParser::str_get_html($viewContents, $lowercase = true, $forceTagsClosed = true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN = false);

        if ($html === false) {
            return $viewContents;
        }

        $elements = array_reverse($html->find($this->getTagSelector($tagHelper)));

        foreach ($elements as $element) {
            $tagHelper->process(HtmlElement::create($element));
        }

        return $html;
    }
}
