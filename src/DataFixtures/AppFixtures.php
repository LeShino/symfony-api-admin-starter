<?php

namespace App\DataFixtures;

use App\Entity\Api;
use App\Entity\Reversement;
use App\Entity\Transaction;
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
            ->setEmail('laubet@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000001')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);

        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Gueu')
            ->setLastName('Detty-Romaric')
            ->setEmail('romdja@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000002')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);

        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Batienan')
            ->setLastName('Olivier-Design-Capisco')
            ->setEmail('capisco@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000003')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);


        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Zougou')
            ->setLastName('Sem JPZ')
            ->setEmail('sem@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000004')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);

        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Kouadio')
            ->setLastName('Modeste Dexter Baoule')
            ->setEmail('dexter@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000005')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);

        $admin = new User();
        $hash = $this->encoder->encodePassword($admin, 'password');
        $admin->setFirstName('Fofana')
            ->setLastName('Sr')
            ->setEmail('fofsr@mail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPhoneNumber('0100000005')
            ->setIsMarchand(false)
            ->setPassword($hash);

        $manager->persist($admin);

        $status = ["Active", "Suspendu", "En maintenance", "Depreciee", "Indisponibilité definitive"];
        for ($i = 0; $i < 10; $i++) {
            $api = new Api();
            $api->setName($this->faker->name())
                ->setUrl($this->faker->url())
                ->setStatus($this->faker->randomElement($status));
            $manager->persist($api);
        }

        for ($j = 0; $j < 10; $j++) {
            $marchand = new User();
            $hash = $this->encoder->encodePassword($marchand, 'password');
            $marchand->setFirstName($this->faker->name())
                ->setLastName($this->faker->name())
                ->setEmail('marchand' . $j . '@wgymail.com')
                ->setRoles(['ROLE_MARCHAND'])
                ->setPhoneNumber('0700000001')
                ->setClientId(mt_rand(1, 100))
                ->setIsMarchand(true)
                ->setClientSecret($this->faker->uuid())
                ->setPassword($hash);

            $manager->persist($marchand);
            $statuTReversement = ["Succès", "Echec", "En attente"];

            for ($k = 0; $k < mt_rand(4, 10); $k++) {
                $reversement = new Reversement();
                $reversement->setReversant('WEBLOGY-OFFSHORE')
                    ->setStatut($this->faker->randomElement($statuTReversement))
                    ->setMontantReverse($this->faker->randomFloat(2, 2500, 50000))
                    ->setDateReversement($this->faker->dateTimeBetween('-6 months'))
                    ->setMarchand($marchand);

                $manager->persist($reversement);
            }

            $paymentMethods = ["Orange Money", "MTN Money", "Moov Money", "Wave", "Visa", "Apaym"];
            for ($k = 0; $k < mt_rand(3, 8); $k++) {
                $transaction = new Transaction();
                $transaction->setAmountPaid($this->faker->randomFloat(2, 1000, 50000))
                    ->setStatus($this->faker->randomElement($statuTReversement))
                    ->setAmountReceived($this->faker->randomFloat(2, 999, 20000))
                    ->setPaymentMethod($this->faker->randomElement($paymentMethods))
                    ->setMotif($this->faker->sentence())
                    ->setReference($this->faker->uuid())
                    ->setTuser($marchand);

                $manager->persist($transaction);
            }
        }

        $manager->flush();
    }
}
