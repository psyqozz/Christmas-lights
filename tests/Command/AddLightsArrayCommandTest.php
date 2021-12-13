<?php

namespace App\Tests\Command;

use App\Entity\Light;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class AddLightsArrayCommandTest extends KernelTestCase
{
    public function testAddLightsIntoArrayCommand()
    {
        $fileSystem = new Filesystem();
        if($fileSystem->exists('lightsDbTest.txt')){
            $fileSystem->remove('lightsDbTest.txt');
        }

        $content = "X Y Active Type Brightness";
        $fileSystem->appendToFile('lightsDbTest.txt', $content);

        for($x = 0; $x <= 10; $x++){
            for($y = 0; $y <= 10; $y++){
                $light = new Light();
                $light->setPositionX($x);
                $light->setPositionY($y);
                $light->setIsActive(false);
                $light->setTypeLight('off');
                $light->setBrightness(0);
                $isActive = $light->getIsActive() == false ? "0" : "1";

                $content = "\n".$light->getPositionX()." ".$light->getPositionY()." ".$isActive." ".$light->getTypeLight()." ".$light->getBrightness();
                $fileSystem->appendToFile('lightsDbTest.txt', $content);
            }
        }

        $this->assertFileExists('lightsDbTest.txt',    'File doest exist');
        $this->assertStringNotEqualsFile('lightsDbTest.txt', '');
    }
}
