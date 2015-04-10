<?php

namespace Ekyna\Bundle\AdvertisementBundle\Entity;

use Ekyna\Bundle\AdvertisementBundle\Model\AdvertInterface;
use Ekyna\Bundle\CoreBundle\Model\TimestampableInterface;
use Ekyna\Bundle\CoreBundle\Model\TimestampableTrait;
use Ekyna\Bundle\UserBundle\Model\AddressInterface;

/**
 * Class Advert
 * @package Ekyna\Bundle\AdvertisementBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Advert implements AdvertInterface, TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var AddressInterface
     */
    protected $address;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var boolean
     */
    protected $validated = false;


    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValidated()
    {
        return $this->validated;
    }
}
