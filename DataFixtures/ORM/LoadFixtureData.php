<?php

namespace Ekyna\Bundle\AdvertisementBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadFixtureData
 * @package Ekyna\Bundle\AdvertisementBundle\DataFixtures\ORM
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class LoadFixtureData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $om)
    {
        $faker = Factory::create($this->container->getParameter('hautelook_alice.locale'));
        $phoneUtil = PhoneNumberUtil::getInstance();

        $advertRepo = $this->container->get('ekyna_advertisement.advert.repository');
        $addressRepo = $this->container->get('ekyna_user.address.repository');
        $genderClass = $this->container->getParameter('ekyna_user.gender_class');

        $genders = call_user_func($genderClass.'::getConstants');

        for ($s = 0; $s < 32; $s++) {

            /** @var \Ekyna\Bundle\UserBundle\Model\AddressInterface $address */
            $address = $addressRepo->createNew();
            $address
                ->setCompany(30 < rand(0,100) ? $faker->sentence(3) : null)
                ->setGender($faker->randomElement($genders))
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setStreet($faker->streetAddress)
                ->setSupplement(70 < rand(0,100) ? $faker->sentence(4) : null)
                ->setPostalCode(str_replace(' ', '' ,$faker->postcode))
                ->setCity($faker->city)
                ->setCountry($faker->countryCode)
                ->setPhone($phoneUtil->parse($faker->phoneNumber, 'FR'))
                ->setMobile(60 < rand(0,100) ? $phoneUtil->parse($faker->phoneNumber, 'FR') : null)
            ;

            /** @var \Ekyna\Bundle\AdvertisementBundle\Model\AdvertInterface $advert */
            $advert = $advertRepo->createNew();
            $advert
                ->setTitle($faker->sentence(rand(4,12)))
                ->setDate($faker->dateTimeBetween('-1 years', 'now'))
                ->setEmail($faker->email)
                ->setAddress($address)
                ->setContent('<p>'.implode('</p><p>',$faker->paragraphs(rand(6,12))).'</p>')
                ->setValidated(30 < rand(0,100))
            ;

            $om->persist($advert);
            $om->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 98;
    }
}
