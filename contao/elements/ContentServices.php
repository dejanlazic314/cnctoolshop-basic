<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentServices extends \Contao\ContentText
{
    /**
    * Template                                              
    * @var string
    */
    protected $strTemplate = 'ce_services';

    /**
    * Generate the content element
    */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        
        $servicesCards = StringUtil::deserialize($this->servicesCards);
        
        // Deserializuj headline za svaki card
        if (is_array($servicesCards)) {
            foreach ($servicesCards as &$card) {
                if (isset($card['headline'])) {
                    $headlineData = StringUtil::deserialize($card['headline']);
                    $card['headline'] = is_array($headlineData) ? $headlineData['value'] : $card['headline'];
                }

                if (isset($card['singleSRC']) && $card['singleSRC']) {
                    $card['singleSRC'] = StringUtil::binToUuid($card['singleSRC']);
                 }
            }
        }
        
        $this->Template->servicesCards = $servicesCards;
    }
}
