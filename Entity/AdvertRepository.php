<?php

namespace Ekyna\Bundle\AdvertisementBundle\Entity;

use Doctrine\DBAL\Types\Type;
use Ekyna\Bundle\AdminBundle\Doctrine\ORM\ResourceRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * Class AdvertRepository
 * @package Ekyna\Bundle\AdvertisementBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertRepository extends ResourceRepository
{
    /**
     * Finds one advert by slug.
     *
     * @param string $slug
     * @return Advert|null
     */
    public function findOneBySlug($slug)
    {
        if (0 == strlen($slug)) {
            return null;
        }

        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->andWhere($qb->expr()->eq('a.validated', ':validated'))
            ->andWhere($qb->expr()->eq('a.slug',    ':slug'))
            ->getQuery()
        ;

        return $query
            ->setMaxResults(1)
            ->setParameters(array(
                'validated' => true,
                'slug' => $slug,
            ))
            ->getOneOrNullResult()
        ;
    }

    /**
     * Finds the latest adverts.
     *
     * @param int $limit
     * @return Advert[]
     */
    public function findLatest($limit = 3)
    {
        $today = new \DateTime();
        $today->setTime(23,59,59);

        $qb = $this->createQueryBuilder('a');
        $query = $qb
            ->andWhere($qb->expr()->eq('a.validated', ':validated'))
            ->andWhere($qb->expr()->lte('a.date', ':today'))
            ->addOrderBy('a.date', 'DESC')
            ->getQuery()
        ;

        return $query
            ->setMaxResults($limit)
            ->setParameter('validated', true)
            ->setParameter('today', $today, Type::DATETIME)
            ->getResult()
        ;
    }
}
