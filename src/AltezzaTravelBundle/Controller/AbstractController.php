<?php

namespace AltezzaTravelBundle\Controller;

use AltezzaTravelBundle\Helper\CalculationHelper;
use AltezzaTravelBundle\Helper\HotelPickUpHelper;
use AltezzaTravelBundle\Helper\HotelRoomHelper;
use AltezzaTravelBundle\Service\CalculationService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractController
 * @package AltezzaTravelBundle\Controller
 */
abstract class AbstractController extends Controller
{
    /**
     * @return EntityManager|object
     */
    public function getEm()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \Symfony\Bridge\Monolog\Logger
     */
    protected function getLogger()
    {
        return $this->container->get('logger');
    }

    /**
     * @return HotelPickUpHelper|object
     */
    public function getHotelPickUpHelper()
    {
        return $this->container->get(HotelPickUpHelper::class);
    }
}
