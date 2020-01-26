<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class HotelChainRepository
 * @package AltezzaTravelBundle\Repository
 */
class HotelChainRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('hotelChain')
            ->orderBy('hotelChain.title', 'ASC');

        return $qb;
    }
}
