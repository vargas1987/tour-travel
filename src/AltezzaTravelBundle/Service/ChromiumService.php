<?php

namespace AltezzaTravelBundle\Service;

use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Cookies\Cookie;
use HeadlessChromium\Page;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ChromeService
 * @package AltezzaTravelBundle\Service
 */
class ChromiumService
{
    /** @var RequestStack */
    private $requestStack;

    /** @var string */
    private $binChromium;

    /**
     * ChromeService constructor.
     * @param RequestStack $requestStack
     * @param string  $binChromium
     */
    public function __construct(RequestStack $requestStack, string $binChromium)
    {
        $this->requestStack = $requestStack;
        $this->binChromium = $binChromium;
    }

    /**
     * @return \HeadlessChromium\Browser\ProcessAwareBrowser
     */
    public function createBrowser()
    {
        $browserFactory = new BrowserFactory($this->binChromium);

        return $browserFactory->createBrowser();
    }

    /**
     * @param $url
     * @return bool|string
     * @throws \HeadlessChromium\Exception\CommunicationException
     * @throws \HeadlessChromium\Exception\CommunicationException\CannotReadResponse
     * @throws \HeadlessChromium\Exception\CommunicationException\InvalidResponse
     * @throws \HeadlessChromium\Exception\CommunicationException\ResponseHasError
     * @throws \HeadlessChromium\Exception\NavigationExpired
     * @throws \HeadlessChromium\Exception\NoResponseAvailable
     * @throws \HeadlessChromium\Exception\OperationTimedOut
     */
    public function generatePdf($url)
    {
        $request = $this->requestStack->getCurrentRequest();
        $request->getSession()->save();
        $browser = $this->createBrowser();

        $page = $browser->createPage();
        $page->setCookies([
            Cookie::create($request->getSession()->getName(), $request->getSession()->getId(), [
                'domain' => $request->getHttpHost(),
                'expires' => time() + 3600 // expires in 1 day
            ])
        ])->await();

        $page->navigate($url)->waitForNavigation(Page::DOM_CONTENT_LOADED, 30000);

        $options = [
            'landscape'       => false,  // default to false
            'printBackground' => true,   // default to false
            'displayHeaderFooter' => true, // default to false
            'preferCSSPageSize' => true, // default to false ( reads parameters directly from @page )
            'marginTop' => 0.0, // defaults to ~0.4 (must be float, value in inches)
            'marginBottom' => 1.4, // defaults to ~0.4 (must be float, value in inches)
            'marginLeft' => 5.0, // defaults to ~0.4 (must be float, value in inches)
            'marginRight' => 1.0 // defaults to ~0.4 (must be float, value in inches)
        ];

        $response = base64_decode($page->pdf($options)->getBase64());
        $browser->close();

        return $response;
    }
}
