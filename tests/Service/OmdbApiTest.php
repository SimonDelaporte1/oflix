<?php

namespace App\Tests\Service;

use App\Service\OmdbApi;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OmdbApiTest extends KernelTestCase
{
    public function testFetch()
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        // (3) run some service & test the result
        $omdbApi = $container->get(OmdbApi::class);

        $result = $omdbApi->fetch('Rambo');
        // On affirme que $result est un tableau
        $this->assertIsArray($result);
        // La clé Title est présente
        $this->assertArrayHasKey('Title', $result);
        // On affirme que la clé Title = Rambo
        $this->assertEquals('Rambo', $result['Title']);
    }
}