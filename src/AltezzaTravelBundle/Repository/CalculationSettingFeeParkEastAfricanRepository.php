<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkEastAfrican;
use AltezzaTravelBundle\Entity\TerritorialPark;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingFeeParkEastAfricanRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingFeeParkEastAfricanRepository extends EntityRepository
{
    /**
     * @param TerritorialPark $park
     * @return CalculationSettingFeeParkEastAfrican|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPriceByPark(TerritorialPark $park)
    {
        return $this->createQueryBuilder('csfpea')
            ->where('csfpea.park = :park')
            ->orderBy('csfpea.id', 'DESC')
            ->setParameter('park', $park)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}