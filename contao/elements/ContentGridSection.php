<?php

namespace Cnctoolshop\ContentElements;

use Contao\ContentText;
use Contao\FilesModel;
use Contao\StringUtil;
use Contao\System;

class ContentGridSection extends ContentText
{
    protected $strTemplate = 'ce_gridSection';

    protected function compile(): void
    {
        $this->Template->headline =
            \Cnctoolshop\Classes\HeadlineEntities::convertEntities($this->headline);

        // Always get an array
        $gridItems = StringUtil::deserialize($this->gridItems, true);

        // Image factory (Contao service)
        $imageFactory = System::getContainer()->get('contao.image.factory');

        if (is_array($gridItems)) {
            foreach ($gridItems as &$item) {

                // -----------------------------
                // Headline per item
                // -----------------------------
                if (isset($item['headline'])) {
                    $headlineData = StringUtil::deserialize($item['headline']);
                    $item['headline'] = is_array($headlineData)
                        ? ($headlineData['value'] ?? '')
                        : (string) $item['headline'];

                    $item['headline'] =
                        \Cnctoolshop\Classes\HeadlineEntities::convertEntities($item['headline']);
                }

                // -----------------------------
                // Image + lightbox URL
                // -----------------------------
                if (!empty($item['singleSRC'])) {

                    // Normalize UUID: multi-column fields often store binary UUID (16 bytes)
                    $raw = $item['singleSRC'];
                    $uuid = $raw;

                    if (is_string($raw) && strlen($raw) === 16) {
                        $uuid = StringUtil::binToUuid($raw);
                    }

                    $item['singleSRC'] = $uuid;

                    $file = FilesModel::findByUuid($uuid);

                    if ($file !== null && is_file($file->path)) {

                        // Create resized image by named size configuration.
                        // The image factory supports using a string for the size config. :contentReference[oaicite:1]{index=1}
                        try {
                            $image = $imageFactory->create($file->path, '_lightbox');
                            $item['lightboxSrc'] = $image->getUrl();
                        } catch (\Throwable $e) {
                            // Fallback to original file path if something goes wrong
                            $item['lightboxSrc'] = $file->path;
                        }

                        // Optional: you might also want a separate URL for the grid thumbnail
                        // $gridImage = $imageFactory->create($file->path, '_gridsection');
                        // $item['gridSrc'] = $gridImage->getUrl();
                    }
                }
            }
        }

        $this->Template->gridItems = $gridItems;
    }
}
