<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Users;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker =  Faker\Factory::create('fr_FR');
        $slugify = new Slugify();
        $users = [];
        for ($h = 1; $h <= 5; $h++) {
                
            $user = new Users();
            $password = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstNameMale());
            $user->setLastName($faker->lastName());
            $user->setEmail("email+".$h."@email.com");
            $slug = $slugify->slugify($user->getFirstName().' '.$user->getlastName());
            $user->setSlug($slug);
            $user->setCity($faker->city());
            $user->setPassword($password);
            $user->setNiveau(1);
 
        $user->setRegisteredAt($faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'));
        $users[] = $user;
        $manager->persist($user);
    }
       

        $manager->flush();
    }
}
