<?php

namespace AltezzaTravelBundle\Controller\Hotels;

use AltezzaTravelBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    public function loginAction()
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('hotels_dashboard');
        }

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('hotels_dashboard');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('@AltezzaTravel/hotels/login.html.twig', [
            'error' => $error,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    public function checkLoginAction()
    {
        return $this->redirectToRoute('hotels_login_check');
    }

    public function logoutAction()
    {
        return $this->redirectToRoute('hotels_logout');
    }
}
