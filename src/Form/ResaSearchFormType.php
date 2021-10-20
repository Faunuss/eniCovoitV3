<?php

namespace App\Form;

use App\Entity\Agence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResaSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('agence', EntityType::class, [
                'class' => Agence::class,
                'label' => 'Agence',
                'choice_label' => 'libelle',
                'required' => false
            ])

            ->add('dateDebut', DateType::class, [
                'label' => 'Entre le ',
                'mapped' => false,
                'widget' => 'single_text',
                'required'=> false
            ])

            ->add('dateFin', DateType::class, [
                'label' => 'et le ',
                'mapped' => false,
                'widget'=> 'single_text',
                'required'=> false
            ])

/*            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => array(
                    'class' => 'btn btn-secondary boutonAccueil'

                )
            ])
*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
