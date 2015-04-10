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
     * Returns the advert pager.
     *
     * @param integer $currentPage
     * @param integer $maxPerPage
     * @return Pagerfanta
     */
    public function createPager($currentPage, $maxPerPage = 12)
    {
        $qb = $this->createQueryBuilder('a');
        $params = ['validated' => true];
        $qb
            ->andWhere($qb->expr()->eq('a.validated', ':validated'))
            ->addOrderBy('a.date', 'DESC')
        ;

        $query = $qb->getQuery();
        $query->setParameters($params);

        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager
            ->setNormalizeOutOfRangePages(true)
            ->setMaxPerPage($maxPerPage)
            ->setCurrentPage($currentPage)
        ;

        return $pager;
    }

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
