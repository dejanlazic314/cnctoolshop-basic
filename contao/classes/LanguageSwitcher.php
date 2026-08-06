<?php
namespace Cnctoolshop\Classes;

use Contao\Database;
use Contao\PageModel;

class LanguageSwitcher
{
    /**
     * Find the page that is the translation counterpart of the given page,
     * using the "languageMain" field in either direction (either the current
     * page points at its counterpart, or the counterpart points back at the
     * current page).
     */
    public static function getCounterpartPage(PageModel $currentPage): ?PageModel
    {
        if ($currentPage->languageMain) {
            $target = PageModel::findWithDetails((int) $currentPage->languageMain);

            if ($target !== null) {
                return $target;
            }
        }

        $result = Database::getInstance()
            ->prepare("SELECT id FROM tl_page WHERE languageMain = ? LIMIT 1")
            ->execute($currentPage->id);

        if ($result->numRows) {
            return PageModel::findWithDetails((int) $result->id);
        }

        return null;
    }
}
