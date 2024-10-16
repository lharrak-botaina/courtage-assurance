<?php
// src/DataFixtures/DevisFixtures.php

namespace App\DataFixtures;

use App\Entity\Devis;
use App\Entity\Client;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DevisFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

       
        $clients = $manager->getRepository(Client::class)->findAll();
        $voitures = $manager->getRepository(Voiture::class)->findAll();

        for ($i = 0; $i < 5; $i++) {
            $devis = new Devis();
            $devis->setDateEffet($faker->dateTimeBetween('now', '+1 year'));
            $devis->setPrix($faker->randomFloat(2, 300, 5000));
            $devis->setFrequencePrix($faker->word);
            $devis->setClient($faker->randomElement($clients));

        
            $randomVoitures = $faker->randomElements($voitures, rand(1, 3)); 
            foreach ($randomVoitures as $voiture) {
                $devis->addVoiture($voiture);
            }

            $manager->persist($devis);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ClientFixtures::class,
            VoitureFixtures::class,
        ];
    }
}