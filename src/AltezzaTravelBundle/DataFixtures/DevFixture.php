<?php

namespace AltezzaTravelBundle\DataFixtures;

use AltezzaTravelBundle\Entity\TerritorialAirstrip;
use AltezzaTravelBundle\Entity\HotelChain;
use AltezzaTravelBundle\Entity\TypeAccommodation;
use AltezzaTravelBundle\Entity\TypeMealPlan;
use AltezzaTravelBundle\Entity\TerritorialArea;
use AltezzaTravelBundle\Entity\TerritorialLocation;
use AltezzaTravelBundle\Entity\TypeSeason;
use AltezzaTravelBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class DevFixture extends Fixture
{
    const SEASON_TYPE_LOW = 'low';

    const SEASON_TYPE_MEDIUM = 'medium';

    const SEASON_TYPE_HIGH = 'high';

    const SEASON_TYPE_PEAK = 'peak';

    const SEASON_TYPES = [
        self::SEASON_TYPE_LOW => 'Low',
        self::SEASON_TYPE_MEDIUM => 'Medium',
        self::SEASON_TYPE_HIGH => 'High',
        self::SEASON_TYPE_PEAK => 'Peak',
    ];

    private $locationsCache = [
        'locations' => [],
        'areas' => [],
        'airports' => [],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setUsername('Alex')
            ->setEmail('ceo@altezza.travel')
            ->setPassword('hrNArf6Oy+67W3fmLWe1Ow==')
            ->setSalt('wmSN4J7lMVri9WYdnRkstqGItK5NLFsUN26KIuTR')
            ->setRoles(['ROLE_ADMIN'])
            ->setActive(true);
        $manager->persist($user);

        $user = (new User())
            ->setUsername('qwe')
            ->setEmail('qwe@qwe.qwe')
            ->setPassword('hrNArf6Oy+67W3fmLWe1Ow==')
            ->setSalt('wmSN4J7lMVri9WYdnRkstqGItK5NLFsUN26KIuTR')
            ->setRoles(['ROLE_ADMIN'])
            ->setActive(true);
        $manager->persist($user);

        foreach (TypeMealPlan::MEAL_PLAN_TYPES as $mealPlanType) {
            $typeMealPlan = new TypeMealPlan();
            $typeMealPlan
                ->setType($mealPlanType)
                ->setTitle(strtoupper($mealPlanType))
            ;

            $manager->persist($typeMealPlan);
        }

        foreach (self::SEASON_TYPES as $type=>$title) {
            $typeSeason = new TypeSeason();
            $typeSeason
                ->setType($type)
                ->setTitle($title)
            ;

            $manager->persist($typeSeason);
        }

        foreach (TypeAccommodation::TRANSFORM_ACCOMMODATION_TYPES as $accommodationType=> $countes) {
            $hotelRoomAccommodation = new TypeAccommodation();

            $hotelRoomAccommodation
                ->setType($accommodationType)
                ->setCountAdult($countes['adult'])
                ->setCountTeenager($countes['teenager'])
                ->setCountChild($countes['child'])
            ;

            $manager->persist($hotelRoomAccommodation);
        }

        $locationsAndAirport = $this->parseLocationsAndAirports(__DIR__, 'locations_and_airports.csv');

        foreach ($locationsAndAirport as $row) {
            $location = isset($this->locationsCache[$row[0]]) ? $this->locationsCache[$row[0]]['entity'] : null;
            if (!$location) {
                $location = (new TerritorialLocation())
                    ->setTitle($row[0]);

                $manager->persist($location);

                $this->locationsCache[$row[0]] = [
                    'entity' => $location,
                    'areas' => [],
                    'airports' => [],
                ];
            }

            $area = null;
            if (!empty($row[1])) {
                $area = isset($this->locationsCache[$row[0]]['areas'][$row[1]])
                    ? $this->locationsCache[$row[0]]['areas'][$row[1]]
                    : null;

                if (!$area) {
                    $area = (new TerritorialArea())
                        ->setTitle($row[1])
                        ->setLocation($location)
                    ;

                    $manager->persist($area);
                    $this->locationsCache[$row[0]]['areas'][$row[1]] = $area;
                }
            }

            if (!empty($row[2])) {
                $airport = (new TerritorialAirstrip())
                    ->setTitle($row[2])
                    ->setType(TerritorialAirstrip::TRANSFER_TYPE_AIRPORT)
                    ->setLocation($location)
                    ->setArea($area)
                ;

                $manager->persist($airport);
                $this->locationsCache[$row[0]]['airports'][$row[2]] = $airport;
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $hotelChain = new HotelChain();
            $hotelChain->setTitle('Hotel Chain '.$i);

            $manager->persist($hotelChain);
        }

        $manager->flush();
    }

    /**
     * @param string $dir
     * @param string $filename
     * @return array
     */
    private function parseLocationsAndAirports($dir, $filename)
    {
        $finder = new Finder();
        $finder->files()
            ->in($dir)
            ->name($filename);

        foreach ($finder as $file) {
            $csv = $file;
        }

        $rows = array();
        if (($handle = fopen($csv->getRealPath(), "r")) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ",")) !== false) {
                $i++;
                if ($i == 1) {
                    continue;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }

        return $rows;
    }
}
