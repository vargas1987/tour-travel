<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\CalculationSettings\CalculationSettingTransfer;
use AltezzaTravelBundle\Entity\CalculationTransfer;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingTransferRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingTransferRepository extends EntityRepository
{
    /**
     * @param CalculationTransfer $transfer
     * @return CalculationSettingTransfer|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPriceByTransfer(CalculationTransfer $transfer)
    {
        return $this->createQueryBuilder('cst')
            ->andWhere('cst.departureTransferTerritorial = :departureTransferTerritorial')
            ->andWhere('cst.arrivalTransferTerritorial = :arrivalTransferTerritorial')
            ->setParameter('departureTransferTerritorial', $transfer->getDeparture())
            ->setParameter('arrivalTransferTerritorial', $transfer->getArrival())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}