<?php
namespace App\DataFixtures;

use App\Entity\Voiture;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class VoitureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        $clients = $manager->getRepository(Client::class)->findAll();
        for ($i = 0; $i < 5; $i++) {
            $voiture = new Voiture();
            $voiture->setNumeroImmatriculation($faker->bothify('##??###'));
            $voiture->setVehicleUsage($faker->word);
            $voiture->setEmplacement($faker->word);
            $voiture->setDateAchat($faker->dateTimeBetween('-5 years', 'now'));

          
            $client = $faker->randomElement($clients);
            $voiture->setClient($client); 

            $manager->persist($voiture);
        }

        $manager->flush(); 
    }
}
