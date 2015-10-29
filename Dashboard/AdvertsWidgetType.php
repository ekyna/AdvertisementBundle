<?php

namespace Ekyna\Bundle\AdvertisementBundle\Dashboard;

use Ekyna\Bundle\AdminBundle\Dashboard\Widget\Type\AbstractWidgetType;
use Ekyna\Bundle\AdminBundle\Dashboard\Widget\WidgetInterface;
use Ekyna\Bundle\AdvertisementBundle\Entity\AdvertRepository;

/**
 * Class AdvertsWidgetType
 * @package Ekyna\Bundle\AdvertisementBundle\Dashboard
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertsWidgetType extends AbstractWidgetType
{
    /**
     * @var AdvertRepository
     */
    private $repository;


    /**
     * Constructor.
     *
     * @param AdvertRepository $repository
     */
    public function __construct(AdvertRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function render(WidgetInterface $widget, \Twig_Environment $twig)
    {
        $adverts = $this->repository->findBy(['validated' => false], ['createdAt' => 'desc'], 6);

        return $twig->render('EkynaAdvertisementBundle:Admin/Dashboard:adverts.html.twig', array(
            'adverts' => $adverts,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'adverts';
    }
}
