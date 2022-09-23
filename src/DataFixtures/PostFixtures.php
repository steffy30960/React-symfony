<?php

namespace App\DataFixtures;
use Faker;
use Faker\Factory;

use App\Entity\Post;
use DateTimeImmutable;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    private $userRepo;
    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');

        $users=$this->userRepo->findAll();
        for ($i=0; $i < 5; $i++) { 
            $post = new Post();
            $post->setImage($faker->image(null, 360, 360, 'animals', true));
            $post->setContent($faker->word());
            $post->setCreatedAt(DateTimeImmutable::createFromMutable($faker->dateTime));
            $post->setUser($faker->randomElement($users));
            
    
           
        
            $manager->persist($post);
        }
        
        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
