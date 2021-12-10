<?php

namespace App\Tests\Command;

use App\Entity\Light;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AddLightsArrayCommandTest extends KernelTestCase
{
    public function testSomething()
    {
        $fileSystem = new Filesystem();
        $content = "X Y Active \n";

        $light = new Light();
        $light->setPositionX(230);
        $light->setPositionY(600);
        $light->setIsActive(false);

        $isActive = $light->getIsActive() == false ? "0" : "1";
        $content .= $light->getPositionX()." ".$light->getPositionY()." ".$isActive."\n";
        $fileSystem->appendToFile('lightsDbTest.txt', $content);

        $this->assertFileExists('lightsDbTest.txt',    'File doest exist');
        $this->assertStringNotEqualsFile('lightsDbTest.txt', '');

        $fileSystem->remove('lightsDbTest.txt');

    }
}
