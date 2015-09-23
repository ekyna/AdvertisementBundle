<?php

namespace Ekyna\Bundle\AdvertisementBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class AdminMenuPass
 * @package Ekyna\Bundle\AdvertisementBundle\DependencyInjection\Compiler
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdminMenuPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroup', [[
            'name'     => 'content',
            'label'    => 'ekyna_core.field.content',
            'icon'     => 'file',
            'position' => 50,
        ]]);
        $pool->addMethodCall('createEntry', ['content', [
            'name'     => 'adverts',
            'route'    => 'ekyna_advertisement_advert_admin_home',
            'label'    => 'ekyna_advertisement.advert.label.plural',
            'resource' => 'ekyna_advertisement_advert',
            'position' => 11,
        ]]);
    }
}
