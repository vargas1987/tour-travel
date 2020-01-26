<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TypeHotelRepository
 * @package AltezzaTravelBundle\Repository
 */
class TypeHotelRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('typeHotel')
            ->orderBy('typeHotel.sort', 'ASC');

        return $qb;
    }
}
