<?php

namespace App\Fixtures;

use App\Entity\Agence;
use App\Entity\Destination;
use App\Entity\EtatResa;
use App\Entity\EtatVehicule;
use App\Entity\TypeVehicule;
use App\Entity\User;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $typeAchat = new TypeVehicule();
        $typeAchat->setLibelle('Achat');
        $typeLoc = new TypeVehicule();
        $typeLoc->setLibelle('Location');
        $typePerso = new TypeVehicule();
        $typePerso->setLibelle('Perso');

        $etatOuvert = new EtatResa();
        $etatOuvert->setLibelle('Ouverte');
        $etatAnnul = new EtatResa();
        $etatAnnul->setLibelle('Annulée');
        $etatClot = new EtatResa();
        $etatClot->setLibelle('Cloturée');
        $etatEff = new EtatResa();
        $etatEff->setLibelle('Effectuée');
        $etatArch = new EtatResa();
        $etatArch->setLibelle('Archivée');

        $etatDispo = new EtatVehicule();
        $etatDispo->setLibelle('Disponible');
        $etatAcc = new EtatVehicule();
        $etatAcc->setLibelle('Accidenté');
        $etatContr = new EtatVehicule();
        $etatContr->setLibelle('Contrôle technique');
        $etatRep = new EtatVehicule();
        $etatRep->setLibelle('En réparation');
        $etatRev = new EtatVehicule();
        $etatRev->setLibelle('En révision');

        $faker = Factory::create('fr_FR');

        $ville = [];

        for($i=0; $i<100; $i++){
            $ville[$i] = new Ville();
            $ville[$i]->setCp((string)$faker->unique()->numberBetween(10000, 95999))
                ->setNom($faker->city);

            $manager->persist($ville[$i]);

        }

        $agence =[];

        for($i=0; $i<10; $i++) {
            $agence[$i] = new Agence();
            $agence[$i]->setLibelle($faker->company)
                ->setRue($faker->streetName)
                ->setVille($ville[$i]);

            $manager->persist($agence[$i]);

        }

        $user = [];

        for($i=0; $i<50; $i++){
            $user[$i] = new User();
            $user[$i]->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setVille($ville[$i])
                ->setRue($faker->streetName)
                ->setAgence($agence[$i])
                ->setEmail($faker->email)
                ->setPseudo($faker->userName)
                ->setTelephone($faker->phoneNumber)
                ->setRoles((array)'ROLE_USER')
                ->setPassword($faker->password);

            $manager->persist($user[$i]);

        }

        $destination = [];

        for($i=0; i<20; $i++){
            $destination[$i] = new Destination();
            $destination[$i]->setRue($faker->streetName)
                ->setLibelle($faker->citySuffix)
                ->setVille($ville[$i]);
        }

        $manager->flush();
    }
}
