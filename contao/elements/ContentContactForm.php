<?php

namespace Cnctoolshop\ContentElements;

use Contao\ContentText;

class ContentContactForm extends \Contao\ContentText
{
    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_contactForm';

    /**
    * Generate the content element
    */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);
    }
}