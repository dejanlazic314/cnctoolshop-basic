<?php

namespace Cnctoolshop\ContentElements;

use Contao\ContentText;
use Contao\StringUtil;

class ContentBenefitsBar extends ContentText
{
    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_benefitsBar';

    /**
    * Generate the content element
    */
    protected function compile(): void
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        $items = StringUtil::deserialize($this->benefitsItems, true);

        $this->Template->items = is_array($items) ? $items : [];

        $this->Template->singleSRC = $this->singleSRC ? StringUtil::binToUuid($this->singleSRC) : null;
    }
}
