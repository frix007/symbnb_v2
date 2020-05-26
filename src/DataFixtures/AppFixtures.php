<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for($i = 1; $i <= 30; $i++) { //boucle jusqu'à 30 ligne
            $ad = new Ad();

            // configuration des fackes news
            $title = $faker->sentence(); // récupérer un titre
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' .join('</p><p>', $faker->paragraphs(5)) . '</p>';

            // ajouter les données dans la base de données
            $ad->setTitle("$title")
            ->setCoverImage("$coverImage")
            ->setIntroduction("$introduction")
            ->setContent("$content")
            ->setPrice(mt_rand(40, 200))
            ->setRooms(mt_rand(1, 5));

            // pour mettre plusieurs images dans la base de données
            for($j = 1; $j <= mt_rand(1, 3); $j++) {  // ajoute par annonce entre 2 à 5 annonce aléatoire
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);

                $manager->persist($image); // pour éviter de taper image devant à chanque fois
            }

            $manager->persist($ad); // pour éviter de taper ad devant à chanque fois
        }

        $manager->flush(); // connexion à la base
    }
}
