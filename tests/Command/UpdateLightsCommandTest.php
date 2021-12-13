<?php

namespace App\Tests\Command;

use App\Entity\Light;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateLightsCommandTest extends KernelTestCase
{
    public function testUpdateLightsCommand()
    {
        $lightsChangement =
        [
            'on' =>
            [
                ['2','3','3','8'],
                ['5','3','7','2'],
                ['8','8','9','6']
            ]
        ];
        $file = new \SplFileObject("lightsDbTest.txt", 'rw');
        $result = "";

        while(!$file->eof()) {
            $content = $file->fgets();
            $result .= $this->UpdatedLineInFile($content, $lightsChangement);
        }
        file_put_contents('lightsDbTest.txt', $result);
        $this->assertStringNotEqualsFile('lightsDbTest.txt', '2 3 1');
        unlink('lightsDbTest.txt');
        $this->assertFileDoesNotExist('lightsDbTest.txt',    'File exist');
    }

    private function UpdatedLineInFile($content, Array $lightsChangement){
        $dataContent = explode(' ', $content, 3);
        $light = new Light();
        $light->setPositionX($dataContent[0]);
        $light->setPositionY($dataContent[1]);
        $light->setIsActive((int)str_replace("\n", "", $dataContent[2]));
        $inverse = !$light->getIsActive() == false ? 0 : 1;

        foreach ($lightsChangement as $type => $lights) foreach($lights as $index){
            $position_x_min = $index[0];
            $position_y_min = $index[1];
            $position_x_max = $index[2];
            $position_y_max = $index[3];
            if(($light->getPositionX() > $position_x_min && $light->getPositionX() < $position_x_max) || ($light->getPositionX() == $position_x_min && $light->getPositionY() >= $position_y_min) || ($light->getPositionX() == $position_x_max && $light->getPositionY() <= $position_y_max)){
                $active = $type == "on" ? 1 : 0;
                $active = $type == 'toggle' ? $inverse : $active;
                $light->setTypeLight($type);
                $content = $light->getPositionX()." ".$light->getPositionY() ." ". $active ." ".$light->getTypeLight()."\n";
            }
        }
        return $content;
    }
}
