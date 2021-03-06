<?php

namespace App\Command;

use App\Entity\Light;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLightsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:update-lights';

    protected function configure(): void
    {
        $this
            ->setDescription('Show light in command line')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to show light')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ordre à respecter pour modifier les lumières : position X min, position Y min, position x max, position Y max
        $lightsChangement =
        [
            'on' =>
            [
                ['887','9','959','629'],
                ['454','398','844','448'],
                ['351','678','951','908']
            ],
            'off' =>
            [
                ['539','243','559','965'],
                ['370','819','676','868'],
                ['145','40','370','997'],
                ['301','3','808','453']
            ],
            "toggle" =>
            [
                ['720','196','897','994'],
                ['831','394','904','860']
            ]
        ];
        $file = new \SplFileObject("lightsDb.txt", 'rw');
        $result = "";

        while(!$file->eof())
        {
            $content = $file->fgets();
            $result .= $this->UpdatedLineInFile($content, $lightsChangement);
        }
        file_put_contents('lightsDb.txt', $result);
        return Command::SUCCESS;
    }

    private function UpdatedLineInFile($content, Array $lightsChangement){

        $dataContent = explode(' ', $content, 5);
        $light = new Light();
        if(count($dataContent) == 5){
            $light->setPositionX($dataContent[0]);
            $light->setPositionY($dataContent[1]);
            $light->setIsActive((int)$dataContent[2]);
            $light->setTypeLight($dataContent[3]);
            $light->setBrightness((int)str_replace("\n", "", $dataContent[4]));
            $inverse = !$light->getIsActive() == false ? 0 : 1;

            foreach ($lightsChangement as $type => $lights){
                foreach($lights as $index){
                    $position_x_min = $index[0];
                    $position_y_min = $index[1];
                    $position_x_max = $index[2];
                    $position_y_max = $index[3];
                    if(($light->getPositionX() > $position_x_min && $light->getPositionX() < $position_x_max) || ($light->getPositionX() == $position_x_min && $light->getPositionY() >= $position_y_min) || ($light->getPositionX() == $position_x_max && $light->getPositionY() <= $position_y_max)){
                        $active = $type == "on" ? 1 : 0;
                        $active = $type == 'toggle' ? $inverse : $active;
                        $light->setTypeLight($type);
                        $content = $light->getPositionX()." ".$light->getPositionY() ." ". $active ." ".$light->getTypeLight()." ".$light->getBrightness()."\n";
                    }
                }
            }
        }
        return $content;
    }
}

