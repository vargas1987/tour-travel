<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CalculationSettingCurrencyRateRepository
 * @package AltezzaTravelBundle\Repository
 */
class CalculationSettingCurrencyRateRepository extends EntityRepository
{
    public function getLastRate(string $currencyFrom, string $currencyTo)
    {
        return $this->createQueryBuilder('cscr')
            ->where('cscr.currencyFrom = :currencyFrom')
            ->andWhere('cscr.currencyTo = :currencyTo')
            ->orderBy('cscr.createdAt', 'DESC')
            ->setParameter('currencyFrom', $currencyFrom)
            ->setParameter('currencyTo', $currencyTo)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}