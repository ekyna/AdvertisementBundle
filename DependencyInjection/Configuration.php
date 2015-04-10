<?php

namespace Ekyna\Bundle\AdvertisementBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\AdvertisementBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_advertisement');

        $this->addPoolsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `pools` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addPoolsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('pools')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('advert')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue(array(
                                    '_form.html' => 'EkynaAdvertisementBundle:Admin/Advert:_form.html',
                                    'show.html'  => 'EkynaAdvertisementBundle:Admin/Advert:show.html',
                                ))->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Entity\Advert')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Controller\Admin\AdvertController')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Entity\AdvertRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Form\Type\AdvertType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Table\Type\AdvertType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->defaultValue('Ekyna\Bundle\AdvertisementBundle\Event\AdvertEvent')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
