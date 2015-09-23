<?php

namespace Ekyna\Bundle\AdvertisementBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AdvertType
 * @package Ekyna\Bundle\AdvertisementBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'ekyna_core.field.title',
            ])
            ->add('date', 'datetime', [
                'label' => 'ekyna_core.field.date',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('email', 'email', [
                'label' => 'ekyna_core.field.email',
            ])
            ->add('validated', 'checkbox', [
                'label' => 'ekyna_core.field.validated',
                'required' => false,
                'attr' => [
                    'align_with_widget' => true,
                ],
            ])
            ->add('address', 'ekyna_user_address', [
                'label' => false,
                'attr' => [
                    'widget_col' => 12,
                ]
            ])
            ->add('content', 'textarea', [
                'label' => 'ekyna_core.field.content',
                'attr' => [
                    'class' => 'tinymce',
                    'data-theme' => 'advanced',
                ],
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
