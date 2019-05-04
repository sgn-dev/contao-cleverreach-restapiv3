<?php

declare(strict_types=1);

/*
 * Cleverreach API V3, 47GradNord - Agentur für Internetlösungen  AllrounderBundle
 *
 * @copyright  Copyright (c) 2008-2018, 47GradNord - Agentur für Internetlösungen
 * @author     47GradNord - Agentur für Internetlösungen <info@47gradnord.de>
 */

namespace Sgn47gradnord\Cleverreachapi\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Sgn47gradnord\Cleverreachapi\CleverreachapiBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(CleverreachapiBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
