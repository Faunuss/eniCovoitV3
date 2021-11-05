<?php

namespace App\Form;

use App\Entity\Agence;
use App\Entity\EtatVehicule;
use App\Entity\TypeVehicule;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, [

            ])
            ->add('immatriculation', TextType::class, [

            ])
            ->add('dateAchat', DateType::class, [
                'widget'=>'single_text',
                'required' => false
            ])
            ->add('type', EntityType::class, [
                'class'=>TypeVehicule::class,
                'choice_label'=>'libelle'
            ])
            ->add('etat', EntityType::class, [
                'class'=>EtatVehicule::class,
                'choice_label'=>'libelle'
            ])
            ->add('agence', EntityType::class, [
                'class'=>Agence::class,
                'choice_label'=>'libelle'
            ])
            ->add('placeVoiture', ChoiceType::class, [
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
            ->add('ajouter', SubmitType::class,[
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
