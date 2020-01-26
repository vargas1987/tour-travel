<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TypeSeason;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class HotelPriceSupplementRepository
 * @package AltezzaTravelBundle\Repository
 */
class HotelPriceSupplementRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getListQb()
    {
        $qb = $this->createQueryBuilder('hps');

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
            ->andWhere(sprintf('hps.hotel = :hotel_%s', $hotel->getId()))
            ->setParameter(sprintf('hotel_%s', $hotel->getId()), $hotel)
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param \DateTime    $dateFrom
     * @param \DateTime    $dateTo
     * @return QueryBuilder
     */
    public function filterListByPeriod(QueryBuilder $qb, \DateTime $dateFrom, \DateTime $dateTo)
    {
        $qb
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->gte('hps.dateFrom', ':dateFrom'),
                    $qb->expr()->lte('hps.dateTo', ':dateFrom')
                ),
                $qb->expr()->andX(
                    $qb->expr()->lte('hps.dateFrom', ':dateTo'),
                    $qb->expr()->gte('hps.dateTo', ':dateTo')
                )
            ))
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
        ;

        return $qb;
    }
}
