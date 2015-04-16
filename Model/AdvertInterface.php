<?php

namespace Ekyna\Bundle\AdvertisementBundle\Model;

use Ekyna\Bundle\CoreBundle\Model\TaggedEntityInterface;
use Ekyna\Bundle\CoreBundle\Model\TimestampableInterface;
use Ekyna\Bundle\UserBundle\Model\AddressInterface;

/**
 * Class AdvertInterface
 * @package Ekyna\Bundle\AdvertisementBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface AdvertInterface extends TimestampableInterface, TaggedEntityInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return AdvertInterface|$this
     */
    public function setDate($date);

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate();

    /**
     * Set title
     *
     * @param string $title
     * @return AdvertInterface|$this
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets the slug.
     *
     * @param string $slug
     * @return AdvertInterface|$this
     */
    public function setSlug($slug);

    /**
     * Returns the slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Set email
     *
     * @param string $email
     * @return AdvertInterface|$this
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set address
     *
     * @param AddressInterface $address
     * @return AdvertInterface|$this
     */
    public function setAddress(AddressInterface $address);

    /**
     * Get address
     *
     * @return AddressInterface
     */
    public function getAddress();

    /**
     * Set content
     *
     * @param string $content
     * @return AdvertInterface|$this
     */
    public function setContent($content);

    /**
     * Get content
     *
     * @return string
     */
    public function getContent();

    /**
     * Set validated
     *
     * @param boolean $validated
     * @return AdvertInterface|$this
     */
    public function setValidated($validated);

    /**
     * Get validated
     *
     * @return boolean
     */
    public function getValidated();
}
