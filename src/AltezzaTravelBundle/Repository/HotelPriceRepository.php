<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TypeSeason;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class HotelPriceRepository
 * @package AltezzaTravelBundle\Repository
 */
class HotelPriceRepository extends EntityRepository
{
    /**
     * @param Hotel $hotel
     */
    public function getByHotel(Hotel $hotel)
    {
        $qb = $this->createQueryBuilder('hp');

        $qb
            ->innerJoin('hp.mealPlanType', 'mp')
            ->innerJoin('hp.season', 's')
            ->innerJoin('hp.room', 'r')
            ->innerJoin('hp.accommodation', 'a')
            ->where('hp.hotel = :hotel')
            ->setParameter('hotel', $hotel)
            ->orderBy('mp.type', 'asc')
            ->orderBy('s.type', 'asc')
            ->orderBy('a.type', 'asc')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function getListQb()
    {
        $qb = $this->createQueryBuilder('hp');

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param Hotel        $hotel
     * @return QueryBuilder
     */
    public function filterListByHotel(QueryBuilder $qb, Hotel $hotel)
    {
        $qb
            ->andWhere(sprintf('hp.hotel = :hotel_%s', $hotel->getId()))
            ->setParameter(sprintf('hotel_%s', $hotel->getId()), $hotel)
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param HotelRoom    $room
     * @return QueryBuilder
     */
    public function filterListByRoom(QueryBuilder $qb, HotelRoom $room)
    {
        $qb
            ->andWhere(sprintf('hp.room = :room_%s', $room->getId()))
            ->setParameter(sprintf('room_%s', $room->getId()), $room)
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param TypeMealPlan $mealPlanType
     * @return QueryBuilder
     */
    public function filterListByTypeMealPlan(QueryBuilder $qb, TypeMealPlan $mealPlanType)
    {
        $qb
            ->andWhere(sprintf('hp.mealPlanType = :mealPlanType_%s', $mealPlanType->getType()))
            ->setParameter(sprintf('mealPlanType_%s', $mealPlanType->getType()), $mealPlanType->getType())
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder      $qb
     * @param TypeAccommodation $accommodationType
     * @return QueryBuilder
     */
    public function filterListByTypeAccommodation(QueryBuilder $qb, TypeAccommodation $accommodationType)
    {
        $qb
            ->andWhere(sprintf('hp.accommodationType = :accommodationType_%s', $accommodationType->getType()))
            ->setParameter(sprintf('accommodationType_%s', $accommodationType->getType()), $accommodationType->getType())
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param TypeSeason   $seasonType
     * @return QueryBuilder
     */
    public function filterListByTypeSeason(QueryBuilder $qb, TypeSeason $seasonType)
    {
        $qb
            ->andWhere(sprintf('hp.seasonType = :seasonType_%s', $seasonType->getType()))
            ->setParameter(sprintf('seasonType_%s', $seasonType->getType()), $seasonType->getType())
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param TypeSeason[] $seasonTypes
     * @return QueryBuilder
     */
    public function filterListByTypeSeasons(QueryBuilder $qb, $seasonTypes)
    {
        $qb->andWhere($qb->expr()->in('hp.seasonType', ':seasonTypes'))
            ->setParameter('seasonTypes', $seasonTypes);

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param int          $yearForm
     * @param int          $yearTo
     * @return QueryBuilder
     */
    public function filterListByYears(QueryBuilder $qb, int $yearForm, int $yearTo)
    {
        $qb->andWhere($qb->expr()->between('hp.year', $yearForm, $yearTo));

        return $qb;
    }
}
