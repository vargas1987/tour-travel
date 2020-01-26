<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TypeRoomRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('typeRoom')
            ->orderBy('typeRoom.sort', 'ASC');

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function filterNotSpecificQB(QueryBuilder $qb)
    {
        $qb->andWhere('typeRoom.specific = false');

        return $qb;
    }

    /**
     * @return array
     */
    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('typeRoom')
            ->orderBy('typeRoom.sort', 'ASC');

        return $qb->getQuery()->getResult();
    }
}