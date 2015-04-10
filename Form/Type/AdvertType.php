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
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'ekyna_core.field.title',
            ))
            ->add('date', 'datetime', array(
                'label' => 'ekyna_core.field.date',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('email', 'email', array(
                'label' => 'ekyna_core.field.email',
            ))
            ->add('validated', 'checkbox', array(
                'label' => 'ekyna_core.field.validated',
                'required' => false,
                'attr' => array(
                    'align_with_widget' => true,
                ),
            ))
            ->add('address', 'ekyna_user_address', array(
                'label' => false,
                'attr' => array(
                    'widget_col' => 12,
                )
            ))
            ->add('content', 'textarea', array(
                'label' => 'ekyna_core.field.content',
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'advanced',
                ),
            ))
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
