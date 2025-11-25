<?php
namespace Cnctoolshop\ContentElements;

use Contao\ContentImage;
use Contao\StringUtil;
use Contao\FilesModel;

class ContentHeroSection extends \Contao\ContentImage
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_heroSection';

    /**
     * Generate the content element
     */
    protected function compile()
    {
        $this->Template->headline = \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        $this->Template->layoutType = $this->layoutType ?: 'background';
        
        if($this->layoutType == 'two-column') {
            $imgSize = 'herosectioncolumn';
        } else {
            $imgSize = 'herosection';
        }

        $this->Template->size = $imgSize;

        if($this->textOptional) {
            $this->Template->text = $this->textOptional;
        }

        if(!$this->linkTitle && $this->url) {
            $this->url = str_replace(['|urlattr'], [''], $this->url);
            $this->Template->linkTitle = str_replace(['|urlattr','url'], ['','title'], $this->url);
        }

        $singleSRC = StringUtil::binToUuid(StringUtil::deserialize($this->singleSRC));
        $this->Template->singleSRC = $singleSRC;

        if($this->mediaSRC OR $this->mediaSRCMobile) {
            if($this->mediaSRC) {
                $this->Template->video = FilesModel::findByUuid(StringUtil::binToUuid($this->mediaSRC))->path;
            }
            if($this->mediaSRCMobile) {
                $this->Template->videoMobile = FilesModel::findByUuid(StringUtil::binToUuid($this->mediaSRCMobile))->path;
            }
        }

        parent::compile();
    }
}