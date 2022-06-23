<?php

namespace App\Tests\Functional\Blog;

use App\Entity\Owner;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{
    private const POST_TITLE = 'Title';
    private const POST_TEXT = 'Description';
    private const OWNER_NAME = 'Owner';
    private const OWNER_LASTNAME = 'Owner';

    public function load(ObjectManager $manager): void
    {
        $owner = new Owner(self::OWNER_NAME, self::OWNER_LASTNAME);
        $manager->persist($owner);
        for ($j = 0; $j < 10; $j++) {
            $post = new Post(
                self::POST_TITLE,
                self::POST_TEXT,
                $owner
            );
            $manager->persist($post);
        }
        $manager->flush();
    }
}
