<?php

namespace Cnctoolshop\ContentElements;

use Contao\ContentText;
use Contao\StringUtil;

class ContentMachineSpecs extends ContentText
{
    /**
    * Template
    * @var string
    */
    protected $strTemplate = 'ce_machineSpecs';

    /**
    * Generate the content element
    */
    protected function compile(): void
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        $items = StringUtil::deserialize($this->machineItems, true);

        if (is_array($items)) {
            foreach ($items as &$item) {
                // Headline per item
                if (isset($item['headline'])) {
                    $headlineData = StringUtil::deserialize($item['headline']);
                    $item['headline'] = is_array($headlineData) ? ($headlineData['value'] ?? '') : (string) $item['headline'];
                    $item['headline'] = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($item['headline']);
                }

                // Image: normalize binary UUID stored inside the group blob
                if (!empty($item['singleSRC'])) {
                    $raw = $item['singleSRC'];
                    $item['singleSRC'] = (is_string($raw) && strlen($raw) === 16) ? StringUtil::binToUuid($raw) : $raw;
                }
            }
        }

        $this->Template->items = $items;
    }
}
