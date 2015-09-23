<?php

namespace Ekyna\Bundle\AdvertisementBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class AdvertType
 * @package Ekyna\Bundle\AdvertisementBundle\Table\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertType extends ResourceTableType
{
    /**
     * {@inheritdoc}
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('id', 'number', [
                'sortable' => true,
            ])
            ->addColumn('title', 'anchor', [
                'label' => 'ekyna_core.field.title',
                'sortable' => true,
                'route_name' => 'ekyna_advertisement_advert_admin_show',
                'route_parameters_map' => [
                    'advertId' => 'id'
                ],
            ])
            ->addColumn('date', 'datetime', [
                'label' => 'ekyna_core.field.date',
                'sortable' => true,
                'time_format' => 'none',
            ])
            ->addColumn('validated', 'boolean', [
                'label' => 'ekyna_core.field.validated',
                'sortable' => true,
                'route_name' => 'ekyna_advertisement_advert_admin_toggle',
                'route_parameters' => ['field' => 'validated'],
                'route_parameters_map' => ['advertId' => 'id'],
            ])
            ->addColumn('actions', 'admin_actions', [
                'buttons' => [
                    [
                        'label' => 'ekyna_core.button.edit',
                        'class' => 'warning',
                        'route_name' => 'ekyna_advertisement_advert_admin_edit',
                        'route_parameters_map' => [
                            'advertId' => 'id'
                        ],
                        'permission' => 'edit',
                    ],
                    [
                        'label' => 'ekyna_core.button.remove',
                        'class' => 'danger',
                        'route_name' => 'ekyna_advertisement_advert_admin_remove',
                        'route_parameters_map' => [
                            'advertId' => 'id'
                        ],
                        'permission' => 'delete',
                    ],
                ],
            ])
            ->addFilter('id', 'number')
            ->addFilter('title', 'text', [
                'label' => 'ekyna_core.field.title'
            ])
            ->addFilter('date', 'datetime', [
                'label' => 'ekyna_core.field.date'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_advertisement_advert';
    }
}
