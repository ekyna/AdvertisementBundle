<?php

namespace Ekyna\Bundle\AdvertisementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SubmitType
 * @package Ekyna\Bundle\AdvertisementBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SubmitType extends AbstractType
{
    /**
     * @var string
     */
    protected $dataClass;


    /**
     * Constructor.
     *
     * @param string $dataClass
     */
    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'ekyna_core.field.title',
            ))
            ->add('email', 'email', array(
                'label' => 'ekyna_core.field.email',
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
                    'data-theme' => 'front',
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => $this->dataClass,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_advertisement_submit';
    }
}
