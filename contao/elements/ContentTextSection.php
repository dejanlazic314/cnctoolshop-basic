<?php

namespace Cnctoolshop\ContentElements;

use Contao\ContentText;

class ContentTextSection extends ContentText
{
    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_textSection';

    /**
    * Generate the content element
    */
    protected function compile(): void
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        $this->Template->textLayout = $this->textLayout ?: 'wide';
        $this->Template->backgroundColor = $this->backgroundColor ?: '';
    }
}
