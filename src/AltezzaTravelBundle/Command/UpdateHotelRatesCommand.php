<?php

namespace AltezzaTravelBundle\Command;

use AltezzaTravelBundle\Entity\Hotel;
use AltezzaTravelBundle\Helper\HotelRateHelper;
use Doctrine\ORM\EntityManager;
use Gedmo\Timestampable\TimestampableListener;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateDateLastPriceCommand
 * @package AltezzaTravelBundle\Command
 */
class UpdateHotelRatesCommand extends ContainerAwareCommand
{
    use DisableTimestampableTrait;

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('altezza:hotels:rates')
            ->setDescription('Update rates from added sites')
            ->setDefinition(
                new InputDefinition([
                    new InputOption('hotel', null, InputOption::VALUE_OPTIONAL, 'Hotel id'),
                ])
            )
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $this->disableTimestampable($em);

        $hotelId = $input->getOption('hotel');

        if ($hotelId) {
            $hotel = $em->getRepository(Hotel::class)->find($hotelId);

            $this->updateHotelRate($hotel);
            $em->flush($hotel);
            $output->writeln(sprintf('Hotel %s was update', $hotel->getTitle()));

            return;
        }

        $hotels = $em->getRepository(Hotel::class)->findAll();
        foreach ($hotels as $hotel) {
            $this->updateHotelRate($hotel);
            $output->writeln(sprintf('Hotel %s was update', $hotel->getTitle()));
        }

        $em->flush();
    }

    /**
     * @param Hotel $hotel
     */
    private function updateHotelRate(Hotel $hotel)
    {
        /** @var HotelRateHelper $hotelRateHelper */
        $hotelRateHelper = $this->getContainer()->get(HotelRateHelper::class);

        $hotelRateHelper->updateHotelRates($hotel);
    }
}
