<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Reservation;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResaCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
 /*           ->add('agence', EntityType::class, [
                'class' => Agence::class,
                'label'=> 'Agence',
                'choice_label' => 'libelle',
            ])
*/
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et heure de la réservation ',
                'widget' => 'single_text'
            ])

            ->add('dateHeureFin', DateTimeType::class, [
                'label' => 'Date et heure de rendu du véhicule',
                'widget' => 'single_text',
                'mapped' => false
            ])

            ->add('nbrePlaces', ChoiceType::class, [
                'label' => 'Nombre de places ',
                'choices' => [
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8
                ]
            ])

            ->add('motif', TextareaType::class, [
                'label' => 'Motif de la réservation '
            ])

            ->add('destination', EntityType::class, [
                'class' => Destination::class,
                'label' => 'Destination ',
                'choice_label' => 'libelle'
            ])

            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'label' => 'Véhicule',
                'choice_label' => 'designation',
            ])

            ->add('publier', SubmitType::class, [
                'label' => 'Publier',
                'attr' => [
                    'class' => 'btn btn-secondary boutonDefault'
                ]
            ])

            ->add('enregistrer', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-secondary boutonDefault'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
