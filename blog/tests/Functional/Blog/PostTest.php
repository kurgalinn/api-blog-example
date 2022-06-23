<?php

namespace App\Tests\Functional\Blog;

use App\Tests\Functional\DatabaseTestCase;

class PostTest extends DatabaseTestCase
{
    public function testPostList(): void
    {
        $fixture = new BlogFixtures();
        $fixture->load($this->em);

        $this->client->request('GET', '/api/posts');
        $content = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertCount(10, $content['hydra:member'], json_encode($content, JSON_PRETTY_PRINT));
    }
}
