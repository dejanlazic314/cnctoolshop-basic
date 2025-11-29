<?php
namespace Cnctoolshop\ContentElements;

use Contao\ContentText;
use Contao\StringUtil;
use Contao\FilesModel;

class ContentFaqSection extends \Contao\ContentText
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_faqSection';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
        
        $accordion = StringUtil::deserialize($this->accordion);
        
        if (is_array($accordion)) {
            foreach ($accordion as &$item) {
                if (isset($item['headline'])) {
                    $headlineData = StringUtil::deserialize($item['headline']);
                    $item['headline'] = is_array($headlineData) ? $headlineData['value'] : $item['headline'];
                    $item['headline'] = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($item['headline']);
                }
            }
        }
        
        $this->Template->accordion = $accordion;
        
        parent::compile();
    }
}