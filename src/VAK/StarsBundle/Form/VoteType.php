<?php

namespace VAK\StarsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voter_user', 'entity', array(
                'class' => "VAKStarsBundle:User",
                'property' => 'username',
                'label' => 'Ki'
            ))
            ->add('voted_user', 'entity', array(
                'class' => "VAKStarsBundle:User",
                'property' => 'username',
                'label' => 'Kire'
            ))
            ->add('comment')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VAK\StarsBundle\Entity\Vote'
        ));
    }

    public function getName()
    {
        return 'vak_starsbundle_votetype';
    }
}
