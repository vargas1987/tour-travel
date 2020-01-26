<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeSupplementRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('typeSupplement')
            ->orderBy('typeSupplement.sort', 'ASC');

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