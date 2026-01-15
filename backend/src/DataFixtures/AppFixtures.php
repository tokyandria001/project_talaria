<?php

namespace App\DataFixtures;

use App\Entity\Place;
use App\Entity\Trip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de quelques lieux (Place)
        for ($i = 1; $i <= 5; $i++) {
            $place = new Place();
            $place->setName("Place $i")
                  ->setDescription("Description du lieu $i")
                  ->setPrice(mt_rand(10, 100)) // prix aléatoire
                  ->setLatitude(48.8 + mt_rand(-100, 100)/1000) // latitude approximative
                  ->setLongitude(2.3 + mt_rand(-100, 100)/1000) // longitude approximative
                  ->setTags(['bar', 'restaurant']); // exemple de tags

            $manager->persist($place);
        }

        // Création de quelques voyages (Trip)
        for ($i = 1; $i <= 3; $i++) {
            $trip = new Trip();
            $trip->setDestination("Destination $i")
                 ->setDateStart(new \DateTime("+$i days"))
                 ->setDateEnd(new \DateTime("+".($i+2)." days"))
                 ->setBudgetTotal(mt_rand(500, 2000));

            $manager->persist($trip);
        }

        // Exécuter la sauvegarde en base
        $manager->flush();
    }
}
