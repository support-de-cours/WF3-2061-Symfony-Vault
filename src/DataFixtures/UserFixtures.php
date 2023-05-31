<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const DATA = [
        [
            'firstname' => "Bruce",
            'lastname' => "WAYNE",
            'email' => "batman@wayne-enterprise.net",
            'password' => "CatWoman",
            'country' => "US",
            'gender' => "N",
            'roles' => ['ROLE_ADMIN']
        ],
        [
            'firstname' => "Tony",
            'lastname' => "STARK",
            'email' => "tony@stark-industries.net",
            'password' => "Mark2Rox",
            'country' => "US",
            'gender' => "N",
            'roles' => ['ROLE_DEVELOPPER']
        ],
    ];

    /**
     * Password Encoder
     *
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $user = new User;

            // Generate password Hash
            $password = $this->encoder->hashPassword($user, $item['password']);

            $user->setFirstname($item['firstname']);
            $user->setLastname($item['lastname']);
            $user->setEmail($item['email']);
            $user->setCountry($item['country']);
            $user->setGender($item['gender']);
            $user->setRoles($item['roles']);
            $user->setBirthday( new DateTime );

            $user->setPassword($password);

            $manager->persist($user);
        }

        // $product = new Product();

        $manager->flush();
    }
}
