<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends AppFixtures
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $owner = new Owner(
                $this->faker->firstNameMale,
                $this->faker->lastName
            );
            $manager->persist($owner);
            for ($j = 0; $j < rand(2, 6); $j++) {
                $post = new Post(
                    $this->faker->realText(30),
                    $this->faker->realText(3000),
                    $owner
                );
                $manager->persist($post);
            }
        }
        $manager->flush();
    }
}
