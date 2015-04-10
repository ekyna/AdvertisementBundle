<?php

namespace Ekyna\Bundle\AdvertisementBundle;

use Ekyna\Bundle\AdvertisementBundle\DependencyInjection\Compiler\AdminMenuPass;
use Ekyna\Bundle\CoreBundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaAdvertisementBundle
 * @package Ekyna\Bundle\AdvertisementBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaAdvertisementBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AdminMenuPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelInterfaces()
    {
        return array(
            'Ekyna\Bundle\AdvertisementBundle\Model\AdvertInterface' => 'ekyna_advertisement.advert.class',
        );
    }
}
