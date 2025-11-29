<?php
namespace Cnctoolshop\ContentElements;

use Contao\ContentImage;
use Contao\StringUtil;
use Contao\FilesModel;

class ContentTextImage extends \Contao\ContentImage
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_textImage';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        $this->Template->textPosition = $this->textPosition ?: 'left';
        $this->Template->backgroundColor = $this->backgroundColor ?: '';
        
        $singleSRC = StringUtil::binToUuid(StringUtil::deserialize($this->singleSRC));
        $this->Template->singleSRC = $singleSRC;

        parent::compile();
    }
}