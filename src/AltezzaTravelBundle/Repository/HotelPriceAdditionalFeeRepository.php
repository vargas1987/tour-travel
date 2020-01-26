<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\Hotel;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class HotelPriceAdditionalFeeRepository
 * @package AltezzaTravelBundle\Repository
 */
class HotelPriceAdditionalFeeRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getListQb()
    {
        $qb = $this->createQueryBuilder('hpaf');

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param Hotel        $hotel
     * @return QueryBuilder
     */
    public function filterListByHotel(QueryBuilder $qb, Hotel $hotel)
    {
        $qb
            ->andWhere(sprintf('hpaf.hotel = :hotel_%s', $hotel->getId()))
            ->setParameter(sprintf('hotel_%s', $hotel->getId()), $hotel)
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param int          $yearForm
     * @param int          $yearTo
     * @return QueryBuilder
     */
    public function filterListByYears(QueryBuilder $qb, int $yearForm, int $yearTo)
    {
        $qb->andWhere($qb->expr()->between('hpaf.year', $yearForm, $yearTo));

        return $qb;
    }
}
