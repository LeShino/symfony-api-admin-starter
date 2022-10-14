<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     *
     */
    private Generator $faker;
    private $encoder;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->faker = Factory::create('fr_FR');
        $this->encoder = $encoder;

    }
    public function load(ObjectManager $manager): void
    {


        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Laubet')
        ->setLastName('Guy-Gael')
        ->setEmail('lgg@mail.com')
        ->setRoles(['ROLE_ADMIN'])
        ->setPhoneNumber('010257021')
        ->setPassword($hash);

        $manager->persist($admin);
        $manager->flush();
    }
}
