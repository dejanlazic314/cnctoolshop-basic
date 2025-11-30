<?php
namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentImageShowcase extends \Contao\ContentGallery
{

    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_imageShowcase';

        /**
    * Generate the content element
    */
    protected function compile()
    {

        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        $this->images = StringUtil::deserialize($this->multiSRC);
        
        $arrayOfImages= [];

        foreach($this->images as $k=>$v){
            $arrayOfImages[$k] = StringUtil::binToUuid($v);
            
        }

        $this->Template->multiSRC = $arrayOfImages;


        parent::compile();
    }

}

            