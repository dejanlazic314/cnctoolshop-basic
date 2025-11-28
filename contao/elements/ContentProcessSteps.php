<?php

namespace Cnctoolshop\ContentElements;

use Contao\StringUtil;
use Contao\FilesModel;

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
                // Obrada headline-a
                if (isset($card['headline'])) {
                    $headlineData = StringUtil::deserialize($card['headline']);
                    $card['headline'] = is_array($headlineData) ? $headlineData['value'] : $card['headline'];
                    $card['headline'] = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($card['headline']);
                }

                // Obrada ikone
                if (isset($card['icon']) && $card['icon']) {
                    $uuid = StringUtil::binToUuid($card['icon']);
                    $iconModel = FilesModel::findByUuid($uuid);
                    
                    if ($iconModel !== null) {
                        $card['iconPath'] = $iconModel->path;
                        $card['iconUrl'] = $iconModel->path;
                    }
                }
            }
        }
        
        $this->Template->stepsCards = $stepsCards;
    }
}