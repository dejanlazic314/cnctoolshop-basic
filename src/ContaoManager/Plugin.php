<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Cnctoolshop\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Cnctoolshop\CnctoolshopBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Contao\NewsBundle\ContaoNewsBundle;


/**
 * @internal
 */
class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(CnctoolshopBundle::class)
            ->setLoadAfter([
                ContaoCoreBundle::class,
                ContaoNewsBundle::class,
            ])
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader, array $config)
    {
        $loader->load('@CnctoolshopBundle/config/config.yaml');
    }
}