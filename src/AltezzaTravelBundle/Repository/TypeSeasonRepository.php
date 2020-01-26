<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeSeasonRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('typeSeason')
            ->orderBy('typeSeason.sort', 'ASC');

        return $qb->getQuery()->getResult();
    }
}