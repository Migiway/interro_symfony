<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('email')
            ->add('cv')
            ->add('offer', EntityType::class, array('class' => Offer::class, 'choice_label' => 'title'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
