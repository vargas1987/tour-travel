<?php

namespace AltezzaTravelBundle\Helper;

use AltezzaTravelBundle\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class HotelRateHelper
 * @package AltezzaTravelBundle\Helper
 */
class HotelRateHelper extends AbstractHelper
{
    const HOTEL_RATES_EXTRADATA = [
        'booking' => 'div.bui-review-score__badge',
        'tripadvisor' => 'span.overallRating',
    ];

    /**
     * @param Hotel $hotel
     */
    public function runUpdateCommand(Hotel $hotel)
    {
        $options = [];
        $options['--hotel'] = $hotel->getId();

        $this->createCommand('altezza:hotels:rates', $options);
    }

    /**
     * @param Hotel $hotel
     */
    public function updateHotelRates(Hotel $hotel)
    {
        foreach (self::HOTEL_RATES_EXTRADATA as $field => $selector) {
            $url = $hotel->getExtraData($field, 'url');

            if (!$url || empty($score = $this->parseScore($url, $selector))) {
                continue;
            }

            $hotel->addExtraData($field, [
                'url' => $url,
                'rate' => $score,
            ]);
        }
    }

    /**
     * @param $url
     * @param $selector
     * @return string
     */
    private function parseScore($url, $selector)
    {
        $content = file_get_contents($url);

        if (!$content) {
            return null;
        }

        $crawler = new Crawler($content);
        $results = $crawler
            ->filter($selector)
            ->extract('_text')
        ;

        return trim(reset($results));
    }
}
