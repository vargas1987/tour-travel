<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingCarRental;
use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingTransfer;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingCarRentalRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingCarRentalRepository extends EntityRepository
{
    /**
     * @param int $days
     * @return CalculationSettingTransfer|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPriceByCountDays(int $days)
    {
        $slug = CalculationSettingCarRental::getSlugByCount($days);

        return $this->createQueryBuilder('cscr')
            ->andWhere('cscr.countDays = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}