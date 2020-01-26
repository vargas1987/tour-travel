<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TypeRoom;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr as Expr;
use Doctrine\ORM\QueryBuilder;

class HotelRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getAllSortedQB()
    {
        $qb = $this->createQueryBuilder('hotel')
            ->orderBy('hotel.title', 'ASC');

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

    /**
     * @return QueryBuilder
     */
    public function getEnabledListQB()
    {
        $qb = $this->getAllSortedQB();

        $qb
            ->andWhere('hotel.status = :status')
            ->setParameter('status', Hotel::STATUS_ENABLED)
        ;

        return $qb;
    }

    /**
     * @param string $select_location
     * @param string $search
     *
     * @return QueryBuilder
     */
    public function searchHotel(string $select_location = null, string $search = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('h');

        $queryBuilder
            ->leftJoin('h.location', 'l')
            ->leftJoin('h.area', 'a')
            ->leftJoin('h.chain', 'c')
        ;

        if ($select_location) {
            $queryBuilder->andWhere('l.id = :id')
                ->setParameter('id', $select_location);
        }

        if ($search) {
            $expression = $queryBuilder->expr();

            $queryBuilder->andWhere(
                $expression->orX(
                    $expression->like('LOWER(h.title)', 'LOWER(:search)'),
                    $expression->like('LOWER(l.title)', 'LOWER(:search)'),
                    $expression->like('LOWER(a.title)', 'LOWER(:search)'),
                    $expression->like('LOWER(c.title)', 'LOWER(:search)')
                )
            )
                ->setParameter('search', "%$search%");
        }

        return $queryBuilder;
    }

    /**
     * @param TerritorialLocation $location
     * @param TerritorialArea[]   $area
     * @return QueryBuilder
     */
    public function getHotelsWithoutMobileCampsByLocationAndAreaQB(TerritorialLocation $location, $area = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('hotel')
            ->innerJoin('hotel.location', 'location', Expr\Join::WITH, 'location = :location')
            ->andWhere('hotel.isMobileCamp = FALSE')
            ->setParameter('location', $location)
        ;

        if ($area) {
            $queryBuilder
                ->innerJoin('hotel.area', 'area', Expr\Join::WITH, 'area in (:area)')
                ->setParameter('area', $area)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param TerritorialLocation $location
     * @param TerritorialArea[]   $area
     * @return QueryBuilder
     */
    public function getHotelsWithMobileCampsByLocationAndAreaQB(TerritorialLocation $location, $area = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('hotel')
            ->innerJoin('hotel.location', 'location', Expr\Join::WITH, 'location = :location')
            ->andWhere('hotel.isMobileCamp = TRUE')
            ->setParameter('location', $location)
        ;

        if ($area) {
            $queryBuilder
                ->innerJoin('hotel.mobileCamps', 'mobileCamp', Expr\Join::WITH, 'mobileCamp.area in (:area)')
                ->setParameter('area', $area)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param \DateTime    $fromDate
     * @param \DateTime    $toDate
     * @return QueryBuilder
     */
    public function filterMobileCampsByDates(QueryBuilder $queryBuilder, \DateTime $fromDate, \DateTime $toDate)
    {
        $queryBuilder
            ->andWhere('mobileCamp.dateFrom <= :fromDate')
            ->andWhere('mobileCamp.dateTo <= :toDate')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
        ;

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder   $queryBuilder
     * @param TypeMealPlan[] $mealPlanType
     * @return QueryBuilder
     */
    public function filterHotelsByMealPlan(QueryBuilder $queryBuilder, array $mealPlanTypes)
    {
        $queryBuilder
            ->innerJoin('hotel.mealPlans', 'mealPlans', Expr\Join::WITH, 'mealPlans in (:mealPlanTypes)')
            ->setParameter('mealPlanTypes', $mealPlanTypes)
        ;

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array        $options
     * @return QueryBuilder
     */
    public function filterHotelsByRooms(QueryBuilder $queryBuilder, array $options)
    {
        foreach ($options as $key=>$roomParams)
        {
            /** @var TypeRoom $roomType */
            $roomType = $roomParams['roomType'];
            /** @var TypeAccommodation[]|ArrayCollection $accommodationTypes */
            $accommodationTypes = $roomParams['accommodations'];

            $roomAlias = sprintf('%s_%s', $roomType->getType(), $key);
            $accommodationAlias = sprintf('accommodation_%s', $roomAlias);
            $queryBuilder
                ->leftJoin(
                    'hotel.rooms',
                    $roomAlias
                )
                ->leftJoin(
                    "{$roomAlias}.accommodations",
                    $accommodationAlias,
                    Expr\Join::WITH,
                    "{$accommodationAlias} IN (:{$accommodationAlias})"
                )
                ->setParameter($accommodationAlias, $accommodationTypes)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return QueryBuilder
     */
    public function filterHotelsByEnabled(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->andWhere('hotel.status = :status')
            ->setParameter('status', Hotel::STATUS_ENABLED)
        ;

        return $queryBuilder;
    }
}
