<?php

namespace App\Command;

use App\Entity\Light;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class UpdateLightsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:show-lights';

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
                ['887','9','959','629',],
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

        $dataContent = explode(' ', $content, 3);
        $light = new Light();
        $light->setPositionX($dataContent[0]);
        $light->setPositionY($dataContent[1]);
        $light->setIsActive((int)str_replace("\n", "", $dataContent[2]));
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
                    $content = $light->getPositionX()." ".$light->getPositionY()." ".$active."\n";
                }
            }
        }
        return $content;
    }
}

