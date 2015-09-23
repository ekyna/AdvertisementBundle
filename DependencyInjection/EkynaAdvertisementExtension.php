<?php

namespace Ekyna\Bundle\AdvertisementBundle\DependencyInjection;

use Ekyna\Bundle\AdminBundle\DependencyInjection\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaAdvertisementExtension
 * @package Ekyna\Bundle\AdvertisementBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaAdvertisementExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configure($configs, 'ekyna_advertisement', new Configuration(), $container);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (array_key_exists('AsseticBundle', $bundles)) {
            $this->configureAsseticBundle($container);
        }
    }

    /**
     * Configures the assetic bundle.
     *
     * @param ContainerBuilder $container
     */
    protected function configureAsseticBundle(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('assetic', [
            'bundles' => ['EkynaAdvertisementBundle']
        ]);
    }
}
