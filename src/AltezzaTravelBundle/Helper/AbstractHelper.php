<?php

namespace AltezzaTravelBundle\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

abstract class AbstractHelper
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string  $name
     * @param array   $options
     * @param boolean $background
     */
    protected function createCommand(string $name, array $options, $background = true)
    {
        $phpBin = (new PhpExecutableFinder())->find();
        if ($this->container->hasParameter('php_bin')) {
            $phpBin = $this->container->hasParameter('php_bin');
        }

        $command = [];
        $command[] = 'nohup';
        $command[] = $phpBin;
        $command[] = realpath($this->container->getParameter('kernel.root_dir').'/../bin/console');
        $command[] = $name;

        foreach ($options as $key => $value) {
            $command[] = "{$key} {$value}";
        }

        $command[] = '-e '.$this->container->getParameter('kernel.environment');
        $command[] = '&';
        $command = implode(' ', $command);

        $process = new Process($command);

        if ($background === true) {
            $process->start();

            usleep(1000000);
            return;
        }

        $process->setTimeout(0);
        $process->setPty(true);
        $process->start();

        $iterator = $process->getIterator();

        foreach ($iterator as $data) {
            echo $data;
        }
    }
}
