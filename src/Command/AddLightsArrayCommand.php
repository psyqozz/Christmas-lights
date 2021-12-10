<?php

namespace App\Command;

use App\Entity\Light;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

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
        $fileSystem = new Filesystem();
        $content = "X Y Active";
        $fileSystem->appendToFile('lightsDb.txt', $content);

        echo "writing of the current file... please wait \n";

        for($x = 0; $x < 1000; $x++){
            for($y = 0; $y < 1000; $y++){
                $light = new Light();
                $light->setPositionX($x);
                $light->setPositionY($y);
                $light->setIsActive(0);

                $isActive = $light->getIsActive() == false ? "0" : "1";
                $content  = "\n".$light->getPositionX()." ".$light->getPositionY()." ".$isActive;
                $fileSystem->appendToFile('lightsDb.txt', $content);
            }
        }

        Echo "File successful created\n";
        return Command::SUCCESS;
    }
}

