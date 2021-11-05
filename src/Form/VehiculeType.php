<?php

namespace App\Form;

use App\Entity\Agence;
use App\Entity\EtatVehicule;
use App\Entity\TypeVehicule;
use App\Entity\Vehicule;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('immatriculation')
            ->add('dateAchat', DateType::class, [
                'widget'=>'single_text',
                'required'=>false
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
            ->add('place_voiture')
            ->add('photo',FileType::class,[
                'mapped'=>false,
                'required'=>false,
                'label'=>'Photo Vehicule',
                'constraints'=>[
                    new File([
                        'maxSize'=>'5000k',
                        'mimeTypesMessage'=>'On veux une photo qui fait moins de 5 Mo'
                    ])
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
