<?php
namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentLogoClients extends \Contao\ContentElement
{

    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_logoClients';

        /**
    * Generate the content element
    */
    protected function compile()
    {

        $this->multiSRC = StringUtil::deserialize($this->multiSRC);
        $arrayOfImages =[];

        foreach ($this->multiSRC as $k => $v) {
            if($v){
                $arrayOfImages[] = StringUtil::binToUuid($v);
            }
        }

        $this->Template->images = $arrayOfImages;
    }
}

            