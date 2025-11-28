<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;
use Contao\FilesModel;
use Contao\Controller;

class ContentTextMedia extends \Contao\ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_textMedia';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        $this->Template->textPosition = $this->textPosition ?: 'left';
        $this->Template->backgroundColor = $this->backgroundColor ?: '';

        // Media Type Logic
        if ($this->mediaType === 'frame') {
            $this->Template->isFrame = true;
            $this->Template->frameHtml = $this->mediaFrame;
        } else {
            $singleSRC = StringUtil::binToUuid(StringUtil::deserialize($this->singleSRC));
            $this->Template->singleSRC = $singleSRC;
        }
    }
}