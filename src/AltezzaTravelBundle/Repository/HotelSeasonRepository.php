<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\Hotel;
use Doctrine\ORM\EntityRepository;

class HotelSeasonRepository extends EntityRepository
{
    /**
     * @param Hotel     $hotel
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @return array
     */
    public function getSeasonsByPeriod(Hotel $hotel, \DateTime $dateFrom, \DateTime $dateTo)
    {
        $qb = $this->createQueryBuilder('hs')
            ->where('hs.hotel = :hotel')
            ->setParameter('hotel', $hotel);

        $qb
            ->andWhere($qb->expr()->andX(
                $qb->expr()->andX(
                    $qb->expr()->gte('hp.dateFrom', ':dateFrom'),
                    $qb->expr()->lte('hp.dateTo', ':dateFrom')
                ),
                $qb->expr()->andX(
                    $qb->expr()->lte('hp.dateFrom', ':dateTo'),
                    $qb->expr()->gte('hp.dateTo', ':dateTo')
                )
            ))
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
        ;

        return $qb->getQuery()->getResult();
    }
}
