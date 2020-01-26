<?php

namespace AltezzaTravelBundle\Controller\Tour;

use AltezzaTravelBundle\Controller\AbstractController;

class AuthController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('tour_dashboard');
        }

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('tour_dashboard');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('@AltezzaTravel/tour/login.html.twig', [
            'error' => $error,
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkLoginAction()
    {
        return $this->redirectToRoute('tour_login');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logoutAction()
    {
        return $this->redirectToRoute('tour_logout');
    }
}
