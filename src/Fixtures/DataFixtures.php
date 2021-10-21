<?php

namespace App\Fixtures;

use App\Entity\Agence;
use App\Entity\Destination;
use App\Entity\EtatResa;
use App\Entity\EtatVehicule;
use App\Entity\Inscription;
use App\Entity\Reservation;
use App\Entity\TypeVehicule;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\Ville;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // TypeVehicule

        $typeAchat = new TypeVehicule();
        $typeAchat->setLibelle('Achat');
        $typeLoc = new TypeVehicule();
        $typeLoc->setLibelle('Location');
        $typePerso = new TypeVehicule();
        $typePerso->setLibelle('Perso');

        $typeVehicule = [$typeAchat, $typeLoc, $typePerso];

        foreach ($typeVehicule as $value){
            $manager->persist($value);
        }

        // EtatResa

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

        $etatResa = [$etatOuvert, $etatAnnul, $etatClot, $etatEff, $etatArch];

        foreach ($etatResa as $value){
            $manager->persist($value);
        }

        // EtatVehicule

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

        $etatVehicule = [$etatDispo, $etatAcc, $etatContr, $etatRep, $etatRev];

        foreach ($etatVehicule as $value){
            $manager->persist($value);
        }

        $faker = Factory::create('fr_FR');

        // Ville

        $ville = [];

        for($i=0; $i<100; $i++){
            $ville[$i] = new Ville();
            $ville[$i]->setCp((string)$faker->unique()->numberBetween(10000, 95999))
                ->setNom($faker->city);

            $manager->persist($ville[$i]);

        }

        // Agence

        $agence =[];

        for($i=0; $i<10; $i++) {
            $agence[$i] = new Agence();
            $agence[$i]->setLibelle($faker->company)
                ->setRue($faker->streetName)
                ->setVille($ville[rand(0, count($ville)-1)]);

            $manager->persist($agence[$i]);

        }

        // User

        $user = [];

        for($i=0; $i<50; $i++){
            $user[$i] = new User();
            $user[$i]->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setVille($ville[rand(0, count($ville)-1)])
                ->setRue($faker->streetName)
                ->setAgence($agence[rand(0, count($agence)-1)])
                ->setEmail($faker->email)
                ->setPseudo($faker->userName)
                ->setTelephone($faker->phoneNumber)
                ->setRoles((array)'ROLE_USER')
                ->setPassword($faker->password);

            $manager->persist($user[$i]);

        }

        // Destination

        $destination = [];

        for($i=0; $i<20; $i++){
            $destination[$i] = new Destination();
            $destination[$i]->setRue($faker->streetName)
                ->setLibelle($faker->citySuffix)
                ->setVille($ville[rand(0, count($ville)-1)]);

            $manager->persist($destination[$i]);
        }

        // Vehicule

        $vehicule = [];

        for($i=0; $i<20; $i++){
            $vehicule[$i] = new Vehicule();
            $vehicule[$i]->setAgence($agence[rand(0, count($agence)-1)])
                ->setDateAchat($faker->dateTime())
                ->setType($typeVehicule[rand(0, count($typeVehicule)-1)])
                ->setEtat($etatVehicule[rand(0, count($etatVehicule)-1)])
                ->setDesignation($faker->text(50))
                ->setImmatriculation(strtoupper($faker->bothify('??-###-??')));

            $manager->persist($vehicule[$i]);

        }

        //Reservation

        $reservation = [];

        for($i=0; $i<20; $i++){
            $reservation[$i] = new Reservation();
            $reservation[$i]->setDateHeureDebut($faker->dateTime)
                ->setDestination($destination[rand(0, count($destination)-1)])
                ->setDuree($faker->numberBetween(1, 168))
                ->setEtatResa($etatResa[rand(0, count($etatResa)-1)])
                ->setNbrePlaces((int)$faker->RandomElement(['2', '5']))
                ->setMotif($faker->text(255))
                ->setConducteur($user[rand(0, count($user)-1)])
                ->setVehicule($vehicule[rand(0, count($vehicule)-1)]);
            if($reservation[$i]->getEtatResa()->getLibelle() == 'Annulée'){
                $reservation[$i]->setMotifAnnulation($faker->text(255));
            }

            $manager->persist($reservation[$i]);

        }

        //Inscription

        $inscription = [];

        for($i; $i=49; $i++){
            $inscription[$i] = new Inscription();
            $inscription[$i]->setUser($user[rand(0, count($user)-1)])
                ->setDateInscription($faker->dateTime('now'))
                ->setReservation($reservation[rand(0, count($reservation)-1)]);

            $manager->persist($inscription[$i]);
        }

        $manager->flush();
    }
}
