<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

abstract class AppFixtures extends Fixture
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }
}
