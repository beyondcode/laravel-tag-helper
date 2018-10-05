<?php

namespace BeyondCode\TagHelper;

use BeyondCode\TagHelper\Html\HtmlElement;
use Illuminate\View\View;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Filesystem\Filesystem;

class TagHelperCompiler
{

    /** @var TagHelper */
    protected $tagHelper;

    /** @var Filesystem */
    protected $files;

    /** @var View */
    protected $view;

    public function __construct(TagHelper $tagHelper, Filesystem $files)
    {
        $this->tagHelper = $tagHelper;
        $this->files = $files;
    }

    public function needsToBeRecompiled($path, $compiled)
    {
        return true;
        if (! $this->files->exists($compiled)) {
            return true;
        }

        return $this->files->lastModified($path) >=
            $this->files->lastModified($compiled);
    }

    public function compile(View $view)
    {
        $this->view = $view;

        $compiled = sys_get_temp_dir() . '/' . $view->name();

        if (! $this->needsToBeRecompiled($view->getPath(), $compiled)) {
            return;
        }

        $viewContent = array_reduce(
            $this->tagHelper->getRegisteredTagHelpers(),
            [$this, 'parseHtml'],
            file_get_contents($view->getPath())
        );

        file_put_contents($compiled, $viewContent);

        /**
         * Lets update the file timestamp so that view caching still works.
         */
        touch($compiled, $this->files->lastModified($view->getPath()));

        $view->setPath($compiled);
    }

    protected function getTagSelector(Helper $tagHelper): string
    {
        $selector = $tagHelper->getTargetElement();
        if (!is_null($tagHelper->getTargetAttribute())) {
            $selector .= "[{$tagHelper->getTargetAttribute()}]";
            $selector .= ", {$tagHelper->getTargetElement()}[:{$tagHelper->getTargetAttribute()}]";
        }

        return $selector;
    }

    protected function parseHtml(string $viewContents, Helper $tagHelper)
    {
        $html = HtmlDomParser::str_get_html($viewContents, $lowercase=true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=false);

        $elements = array_reverse($html->find($this->getTagSelector($tagHelper)));

        foreach ($elements as $element) {
            $tagHelper->process(HtmlElement::create($element, $this->view->getData()));
        }

        return $html;
    }

}