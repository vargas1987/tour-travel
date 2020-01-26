<?php

namespace AltezzaTravelBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\FirewallMapInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class ExceptionListener
 * @package AltezzaTravelBundle\EventListener
 */
class ExceptionListener implements EventSubscriberInterface
{
    const SECURITY_FIREWALL_HOTELS = 'hotels';

    const SECURITY_FIREWALL_TOUR = 'tour';

    /**
     * @var TwigEngine|EngineInterface
     */
    private $templateEngine;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var FirewallMap|FirewallMapInterface
     */
    private $firewall;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $environment;

    /**
     * ConsoleExceptionListener constructor.
     * @param EngineInterface       $templateEngine
     * @param LoggerInterface       $logger
     * @param TokenStorageInterface $tokenStorage
     * @param FirewallMapInterface  $firewall
     * @param RouterInterface       $router
     * @param string                $environment
     */
    public function __construct(
        EngineInterface $templateEngine,
        LoggerInterface $logger,
        TokenStorageInterface $tokenStorage,
        FirewallMapInterface $firewall,
        RouterInterface $router,
        string $environment
    ) {
        $this->templateEngine = $templateEngine;
        $this->logger = $logger;
        $this->tokenStorage = $tokenStorage;
        $this->firewall = $firewall;
        $this->router = $router;
        $this->environment = $environment;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelException', -128],
        ];
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @throws \Twig\Error\Error
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getException();

        if ($this->environment !== 'prod') {
            return;
        }

        if (!$config = $this->firewall->getFirewallConfig($request)) {
            $event->setResponse(new Response('copyright altezza.travel'));

            return;
        }

        switch ($config->getName()) {
            case self::SECURITY_FIREWALL_HOTELS:
                $errorTemplate = '@AltezzaTravel/hotels/error/error.html.twig';
                $error404Template = '@AltezzaTravel/hotels/error/error404.html.twig';
                break;
            case self::SECURITY_FIREWALL_TOUR:
                $errorTemplate = '@AltezzaTravel/tour/error/error.html.twig';
                $error404Template = '@AltezzaTravel/tour/error/error404.html.twig';
                break;
            default:
                $errorTemplate = '@AltezzaTravel/hotels/error/error.html.twig';
                $error404Template = '@AltezzaTravel/hotels/error/error404.html.twig';
        }

        if ($exception instanceof NotFoundHttpException) {
            $response = $this->templateEngine->renderResponse($error404Template, array(
                'message' => $exception->getMessage(),
            ));

            $event->setResponse($response);

            return;
        }

        if ($exception instanceof AccessDeniedHttpException || $exception instanceof AccessDeniedException) {
            if (!($this->tokenStorage->getToken() instanceof AnonymousToken)) {
                $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                $response = $this->templateEngine->renderResponse($errorTemplate, array(
                    'message' => $exception->getMessage(),
                ));

                $event->setResponse($response);

                return;
            }

            return;
        }

        $this->logger->critical($exception->getMessage(), ['exception' => $exception]);

        $response = $this->templateEngine->renderResponse($errorTemplate, array(
            'message' => 'Something went wrong',
        ));
        $event->setResponse($response);
    }
}
