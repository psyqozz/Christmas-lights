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
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $fileSystem = new Filesystem();

        $light = new Light();
        $light->setPositionX(230);
        $light->setPositionY(600);
        $light->setIsActive(false);
        $jsonContent = $serializer->serialize($light, 'json');
        $fileSystem->appendToFile('lightsDbTest.txt', $jsonContent);

        $this->assertFileExists('lightsDbTest.txt',    'File doest exist');
        $this->assertStringNotEqualsFile('lightsDbTest.txt', '');

        $fileSystem->remove('lightsDbTest.txt');


    }
}
