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
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('user', 'entity', array(
                'class' => "VAKStarsBundle:User",
                'property' => 'username'
            ))
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
