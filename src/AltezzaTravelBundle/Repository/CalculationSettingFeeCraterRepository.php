<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeCrater;
use AltezzaTravelBundle\Entity\TerritorialPark;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingFeeCraterRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingFeeCraterRepository extends EntityRepository
{
    /**
     * @param TerritorialPark $park
     * @return CalculationSettingFeeCrater|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPriceByPark(TerritorialPark $park)
    {
        return $this->createQueryBuilder('csfc')
            ->where('csfc.park = :park')
            ->orderBy('csfc.id', 'DESC')
            ->setParameter('park', $park)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
