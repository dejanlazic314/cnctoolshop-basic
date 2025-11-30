<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentGridSection extends \Contao\ContentText
{
    /**
    * Template                                              
    * @var string
    */
    protected $strTemplate = 'ce_gridSection';

    /**
    * Generate the content element
    */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        
        $gridItems = StringUtil::deserialize($this->gridItems);
        
        // Deserializuj headline za svaki item
        if (is_array($gridItems)) {
            foreach ($gridItems as &$item) {
                if (isset($item['headline'])) {
                    $headlineData = StringUtil::deserialize($item['headline']);
                    $item['headline'] = is_array($headlineData) ? $headlineData['value'] : $item['headline'];
                    $item['headline'] = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($item['headline']);
                }

                if (isset($item['singleSRC']) && $item['singleSRC']) {
                    $item['singleSRC'] = StringUtil::binToUuid($item['singleSRC']);
                 }
            }
        }
        
        $this->Template->gridItems = $gridItems;
    }
}