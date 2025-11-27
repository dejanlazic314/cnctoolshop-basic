<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;

class ContentProcessSteps extends \Contao\ContentText
{
    /**
    * Template                                              
    * @var string
    */
    protected $strTemplate = 'ce_processSteps';

    /**
    * Generate the content element
    */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        
        $stepsCards = StringUtil::deserialize($this->stepsCards);
        
        // Deserializuj headline za svaki card
        if (is_array($stepsCards)) {
            foreach ($stepsCards as &$card) {
                if (isset($card['headline'])) {
                    $headlineData = StringUtil::deserialize($card['headline']);
                    $card['headline'] = is_array($headlineData) ? $headlineData['value'] : $card['headline'];
                    $card['headline'] = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($card['headline']);
                }

                if (isset($card['singleSRC']) && $card['singleSRC']) {
                    $card['singleSRC'] = StringUtil::binToUuid($card['singleSRC']);
                 }
            }
        }
        
        $this->Template->stepsCards = $stepsCards;
    }
}
