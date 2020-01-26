<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingFeeParkForeigner;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TerritorialPark;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingFeeParkForeignerRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingFeeParkForeignerRepository extends EntityRepository
{
    /**
     * @param TerritorialPark $park
     * @return CalculationSettingFeeParkForeigner|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPriceByPark(TerritorialPark $park)
    {
        return $this->createQueryBuilder('csfpf')
            ->where('csfpf.park = :park')
            ->orderBy('csfpf.id', 'DESC')
            ->setParameter('park', $park)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}