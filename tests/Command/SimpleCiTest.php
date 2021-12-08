<?php

namespace App\Tests\Command;

use App\Entity\Light;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SimpleCiTest extends KernelTestCase
{
    public function testSomething()
    {
        $light = new Light();
        $light->setPositionX(150);

        $this->assertEquals(150, $light->getPositionX());
    }
}
