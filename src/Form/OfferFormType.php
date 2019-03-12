<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Job;
use App\Entity\Offer;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('contract_id', EntityType::class, array('class' => Contract::class, 'choice_label' => 'label'))
            ->add('job_id', EntityType::class, array(
                //cherche les choix pour cette entité
                'class' => Job::class,

                //texte du choix
                'choice_label' => 'label'
            ))
            /*->add('skill_id', EntityType::class, array(
                //cherche les choix pour cette entité
                'class' => Skill::class,

                //texte du choix
                'choice_label' => 'label'
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
