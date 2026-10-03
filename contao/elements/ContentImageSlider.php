<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentImageSlider extends \Contao\ContentGallery
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_imageSlider';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        $images = StringUtil::deserialize($this->multiSRC);

        $arrayOfImages = [];

        foreach ($images as $k => $v) {
            $arrayOfImages[$k] = StringUtil::binToUuid($v);
        }

        $this->Template->multiSRC = $arrayOfImages;

        parent::compile();
    }
}
