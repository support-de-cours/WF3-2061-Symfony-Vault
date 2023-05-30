<?php

namespace App\DataFixtures;

use App\Entity\Precious;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PreciousFixtures extends Fixture
{
    const DATA = [
        [
            'name' => "My first precious item",
            'description' => "The description of my first precious item"
        ],
        [
            'name' => "My second precious item",
            'description' => "The description of my second precious item"
        ],
        [
            'name' => "My third precious item",
            'description' => "The description of my third precious item"
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            // Instance de l'entité Precious
            $precious = new Precious;

            // Affectation des données
            $precious->setName( $item['name'] );
            $precious->setDescription( $item['description'] );

            // Persistence des données
            $manager->persist( $precious );
        }

        $manager->flush();
    }
}
