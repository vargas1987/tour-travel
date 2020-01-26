<?php

namespace AltezzaTravelBundle\Repository;

use AltezzaTravelBundle\Entity\HotelRoom;
use AltezzaTravelBundle\Entity\TypeRoom;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class TypeAccommodationRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('typeAccommodation')
            ->orderBy('typeAccommodation.countAdult', 'DESC')
            ->addOrderBy('typeAccommodation.countTeenager', 'DESC')
            ->addOrderBy('typeAccommodation.countChild', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param HotelRoom $room
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAvailableAccommodationByRoomQB(HotelRoom $room)
    {
        $qb = $this->createQueryBuilder('typeAccommodation')
            ->leftJoin('typeAccommodation.roomTypes', 'rtConnection')
            ->innerJoin('rtConnection.roomType', 'rt')
            ->innerJoin('rt.rooms', 'r', Join::WITH, 'r.id = :roomId')
            ->where('rtConnection.roomType = :type')
            ->andWhere('rtConnection.accommodationType in (:accommodations)')
            ->setParameter('type', $room->getRoomType())
            ->setParameter('roomId', $room->getId())
            ->setParameter('accommodations', $room->getAccommodations())
            ->orderBy('rtConnection.sort', 'ASC')
        ;

        return $qb;
    }

    /**
     * @param TypeRoom $roomType
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAvailableAccommodationByRoomTypeQB(TypeRoom $roomType)
    {
        $qb = $this->createQueryBuilder('typeAccommodation')
            ->leftJoin('typeAccommodation.roomTypes', 'rtConnection')
            ->where('rtConnection.roomType = :type')
            ->setParameter('type', $roomType)
            ->orderBy('rtConnection.sort', 'ASC')
        ;

        return $qb;
    }
}
