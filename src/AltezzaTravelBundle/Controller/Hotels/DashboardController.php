<?php

namespace AltezzaTravelBundle\Controller\Hotels;

use AltezzaTravelBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function indexAction()
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('hotels_login');
        }

        return $this->redirectToRoute('hotels_list');
    }
}
