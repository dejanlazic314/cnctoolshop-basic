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

        $this->Template->listitems = StringUtil::deserialize($this->listitems);
    }
}
