<?php

declare(strict_types=1);

namespace Cnctoolshop\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\CoreBundle\Security\DataContainer\CreateAction;
use Contao\DC_Table;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Limits the element type select to the groups listed in GROUPS.
 * Priority > 0 so it replaces the core options callback (priority 0).
 */
class ContentElementTypeListener
{
    // Element groups (keys of $GLOBALS['TL_CTE']) that can be selected in the backend
    private const GROUPS = ['Custom Elements'];

    public function __construct(private readonly Security $security)
    {
    }

    #[AsCallback(table: 'tl_content', target: 'fields.type.options', priority: 10)]
    public function getOptions(DC_Table $dc): array
    {
        $groups = [];

        foreach (self::GROUPS as $group) {
            foreach (array_keys($GLOBALS['TL_CTE'][$group] ?? []) as $type) {
                if ($this->isAllowed($dc, $type)) {
                    $groups[$group][] = $type;
                }
            }
        }

        // Keep the current core type selectable so existing elements are not silently changed
        $current = $dc->activeRecord?->type;

        if ($current && !\in_array($current, array_merge(...array_values($groups)), true)) {
            foreach ($GLOBALS['TL_CTE'] as $group => $elements) {
                if (isset($elements[$current])) {
                    $groups[$group][] = $current;
                    break;
                }
            }
        }

        return $groups;
    }

    private function isAllowed(DC_Table $dc, string $type): bool
    {
        $action = new CreateAction('tl_content', [
            'ptable' => $dc->parentTable,
            'pid' => $dc->currentPid,
            'type' => $type,
        ]);

        return $this->security->isGranted(ContaoCorePermissions::DC_PREFIX.'tl_content', $action);
    }
}
