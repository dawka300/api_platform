<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $x = 0;
        foreach ($this->dataProvider() as $value) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($value['title'].$x);
            $blogPost->setPublished($value['published']);
            $blogPost->setContent($value['content'].$x);
            $blogPost->setAuthor($value['author'].$x);
            $blogPost->setSlug($value['slug'].$x);
            $manager->persist($blogPost);
            $x++;
        }

        $manager->flush();
    }

    private function dataProvider()
    {
        return [
            [
                'title' => 'A new one',
                'published' => new \DateTime('2020-01-01 13:00:00'),
                'content' => 'TEXT!!!',
                'author' => 'Gal Anonim',
                'slug' => 'a-new-one'
            ],
            [
                'title' => 'A new one',
                'published' => new \DateTime('2020-01-01 13:00:00'),
                'content' => 'TEXT!!!',
                'author' => 'Gal Anonim',
                'slug' => 'a-new-one'
            ],
            [
                'title' => 'A new one',
                'published' => new \DateTime('2020-01-01 13:00:00'),
                'content' => 'TEXT!!!',
                'author' => 'Gal Anonim',
                'slug' => 'a-new-one'
            ],
            [
                'title' => 'A new one',
                'published' => new \DateTime('2020-01-01 13:00:00'),
                'content' => 'TEXT!!!',
                'author' => 'Gal Anonim',
                'slug' => 'a-new-one'
            ],
            [
                'title' => 'A new one',
                'published' => new \DateTime('2020-01-01 13:00:00'),
                'content' => 'TEXT!!!',
                'author' => 'Gal Anonim',
                'slug' => 'a-new-one'
            ],

        ];
    }
}
