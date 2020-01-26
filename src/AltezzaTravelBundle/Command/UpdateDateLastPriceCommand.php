<?php

namespace AltezzaTravelBundle\Command;

use AltezzaTravelBundle\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateDateLastPriceCommand
 * @package AltezzaTravelBundle\Command
 */
class UpdateDateLastPriceCommand extends ContainerAwareCommand
{
    use DisableTimestampableTrait;

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('altezza:hotels:date-last-price')
            ->setDescription('Update Date Last Price')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $this->disableTimestampable($em);

        /** @var Hotel[] $hotels */
        $hotels = $em->getRepository(Hotel::class)->findAll();

        foreach ($hotels as $hotel) {
            $hotel->setPriceUpTo($hotel->getDateLastPrice());
        }

        $em->flush();
    }
}
