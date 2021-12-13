<?php

namespace App\Command;

use App\Entity\Light;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class BrightnessLightsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:setup-brightness';

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
        $file = new \SplFileObject("lightsDb.txt", 'rw');
        $result = "";

        while(!$file->eof()) {
            $content = $file->fgets();
            $dataContent = explode(' ', $content, 5);
            $light = new Light();
            $light->setPositionX($dataContent[0]);
            $light->setPositionY($dataContent[1]);
            $light->setIsActive((int)$dataContent[2]);
            $light->setTypeLight($dataContent[3]);
            $light->setBrightness((int)str_replace("\n", "", $dataContent[4]));

            if($light->getTypeLight() != "Type"){
                $brigtness = match ($light->getTypeLight()) {
                    'on' => $light->setBrightness(1),
                    'toggle' =>$light->setBrightness(2),
                    'off' => $light->setBrightness(0),
                };
                $result .= $light->getPositionX()." ".$light->getPositionY() ." ". $light->getIsActive() ." ".$light->getTypeLight()." ".$light->getBrightness()."\n";
            } else {
                $result .= $content;
            }
        }
        file_put_contents('lightsDb.txt', $result);

        Echo "File successful edited\n";
        return Command::SUCCESS;
    }
}

