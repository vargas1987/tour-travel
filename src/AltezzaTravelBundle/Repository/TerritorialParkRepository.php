<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TerritorialParkRepository
 * @package AltezzaTravelBundle\Repository
 */
class TerritorialParkRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('tp')
            ->orderBy('tp.title', 'ASC');

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCraterFeeQB()
    {
        $qb = $this->getAllSortedQB()
            ->andWhere('tp.isCrater = :isCrater')
            ->setParameter('isCrater', true);

        return $qb;
    }
}
