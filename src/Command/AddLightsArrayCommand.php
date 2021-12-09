<?php

namespace App\Command;

use App\Entity\Light;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddLightsArrayCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:add-lights-array';

    protected function configure(): void
    {
        $this
            ->setDescription('Add light into file lightsDb.txt')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to add light into lightsDb.txt')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $fileSystem = new Filesystem();

        echo "writing of the current file... please wait \n";

        for($x = 0; $x < 1000; $x++){
            for($y = 0; $y < 1000; $y++){
                $light = new Light();
                $light->setPositionX($x);
                $light->setPositionY($y);
                $light->setIsActive(false);

                $jsonContent = $serializer->serialize($light, 'json');
                $fileSystem->appendToFile('lightsDb.txt', $jsonContent);
            }
        }

        Echo "File successful created";
        return Command::SUCCESS;
    }
}

