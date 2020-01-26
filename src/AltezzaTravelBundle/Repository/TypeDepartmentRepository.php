<?php

namespace AltezzaTravelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TypeDepartmentRepository
 * @package AltezzaTravelBundle\Repository
 */
class TypeDepartmentRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('typeDepartment')
            ->orderBy('typeDepartment.sort', 'ASC');

        return $qb;
    }
}
