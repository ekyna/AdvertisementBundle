<?php

namespace Ekyna\Bundle\AdvertisementBundle\Event;

use Ekyna\Bundle\AdminBundle\Event\ResourceEvent;
use Ekyna\Bundle\AdvertisementBundle\Model\AdvertInterface;

/**
 * Class AdvertEvent
 * @package Ekyna\Bundle\AdvertisementBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertEvent extends ResourceEvent
{
    /**
     * Constructor.
     *
     * @param AdvertInterface $advert
     */
    public function __construct(AdvertInterface $advert)
    {
        $this->setResource($advert);
    }

    /**
     * @return AdvertInterface
     */
    public function getAdvert()
    {
        return $this->resource;
    }
}
