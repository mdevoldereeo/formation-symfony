<?php

namespace Europa\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', 
                    null, 
                    array(
                      'attr' => array('class' => 'form-control')
                      ))
            ->add('firstname', 
                    null, 
                    array(
                      'attr' => array('class' => 'form-control')
                      ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Europa\BlogBundle\Entity\Author'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'europa_blogbundle_author';
    }
}
