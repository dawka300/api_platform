<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var Factory
     */
    private $facker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->facker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
      $this->loadUsers($manager);
      $this->loadBlogPosts($manager);
      $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager) {
        $x = 0;
        foreach ($this->dataPostsProvider() as $value) {
            $author = $this->getReference('user'.$x);
            $blogPost = new BlogPost();
            $blogPost->setTitle($value['title'].$x);
            $blogPost->setPublished($value['published']);
            $blogPost->setContent($value['content'].$x);
            $blogPost->setAuthor($author);
            $blogPost->setSlug($value['slug'].$x);

            $this->addReference('blog'.$x, $blogPost);

            $manager->persist($blogPost);
            $x++;
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager) {
         for ($i = 0; $i < 100; $i++) {
             $comment = new Comment();
             $comment->setContent($this->facker->realText());
             $comment->setPublished($this->facker->dateTime());
             $comment->setAuthor($this->getReference('user'.rand(1,4)));
             $comment->setBlogPost($this->getReference('blog'.rand(1,4)));
             $manager->persist($comment);
         }
         $manager->flush();
    }

    public function loadUsers(ObjectManager $manager) {
        $x = 0;
        foreach ($this->dataUserProvider() as $userData) {
            $user = new User();
            $user->setUsername($userData['username'].$x);
            $user->setEmail($x.$userData['email']);
            $user->setFullName($userData['fullName'].$x);
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user, $userData['password'].$x)
            );

            if($this->hasReference('user'.$x)){
                $this->setReference('user'.$x, $user);
            }else{
                $this->addReference('user'.$x, $user);
            }
            $x++;


            $manager->persist($user);
        }

        $manager->flush();
    }

    private function dataPostsProvider()
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

    private function dataUserProvider() {
        return [
            [
                'username' => 'Richard',
                'email' => 'wp@wp.pl',
                'fullName' => 'Dawid Wesołowski',
                'password' => 'secret'

            ],
            [
                'username' => 'Richard',
                'email' => 'wp@wp.pl',
                'fullName' => 'Dawid Wesołowski',
                'password' => 'secret'

            ],
            [
                'username' => 'Richard',
                'email' => 'wp@wp.pl',
                'fullName' => 'Dawid Wesołowski',
                'password' => 'secret'

            ],
            [
                'username' => 'Richard',
                'email' => 'wp@wp.pl',
                'fullName' => 'Dawid Wesołowski',
                'password' => 'secret'

            ],
            [
                'username' => 'Richard',
                'email' => 'wp@wp.pl',
                'fullName' => 'Dawid Wesołowski',
                'password' => 'secret'

            ]
        ];
    }
}
