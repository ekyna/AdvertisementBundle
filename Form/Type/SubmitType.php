<?php

namespace Ekyna\Bundle\AdvertisementBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'label' => 'ekyna_core.field.title',
            ])
            ->add('email', 'email', [
                'label' => 'ekyna_core.field.email',
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
                    'data-theme' => 'front',
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => $this->dataClass,
            ])
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
