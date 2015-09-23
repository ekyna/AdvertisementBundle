<?php

namespace Ekyna\Bundle\AdvertisementBundle\Entity;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Ekyna\Bundle\AdminBundle\Doctrine\ORM\ResourceRepository;

/**
 * Class AdvertRepository
 * @package Ekyna\Bundle\AdvertisementBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdvertRepository extends ResourceRepository
{
    /**
     * Returns the front events pager.
     *
     * @param integer $currentPage
     * @param integer $maxPerPage
     * @return \Pagerfanta\Pagerfanta
     */
    public function createFrontPager($currentPage, $maxPerPage = 12)
    {
        $qb = $this->getCollectionQueryBuilder();

        $query = $qb
            ->addOrderBy('a.date', 'desc')
            ->andWhere($qb->expr()->eq('a.validated', ':validated'))
            ->getQuery()
        ;

        $query
            ->setParameter('validated', true)
        ;

        return $this
            ->getPager($query)
            ->setMaxPerPage($maxPerPage)
            ->setCurrentPage($currentPage)
        ;
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
            ->setParameters([
                'validated' => true,
                'slug' => $slug,
            ])
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
        $qb
            ->andWhere($qb->expr()->eq('a.validated', ':validated'))
            ->andWhere($qb->expr()->lte('a.date', ':today'))
            ->addOrderBy('a.date', 'DESC')
            ->getQuery()
            ->setMaxResults($limit)
            ->setParameter('validated', true)
            ->setParameter('today', $today, Type::DATETIME)
        ;

        return new Paginator($qb->getQuery(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function getAlias()
    {
        return 'a';
    }
}
