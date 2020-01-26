<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TypeMealPlanRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('typeMealPlan')
            ->orderBy('typeMealPlan.sort', 'ASC');

        return $qb;
    }

    /**
     * @return array
     */
    public function findAllSorted()
    {
        $qb = $this->getAllSortedQB();

        return $qb->getQuery()->getResult();
    }
}