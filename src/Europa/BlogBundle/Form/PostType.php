<?php

namespace Europa\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(  'title', 
                    null, 
                    array(
                      'attr' => array('class' => 'form-control')
                      )
              )
              ->add(
                'body',
                null,
                array(
                  'attr' => array('class' => 'form-control')
                )
              )
              ->add(
                'author', 
                new AuthorType()
              )
              ->add('Publish', 
                'submit',
                array(
                  'attr' => array('class' => 'btn btn-primary')
                  )
                )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Europa\BlogBundle\Entity\Post',
            'cascade_validation' => true // Requis pour valider les champs d'un formulaire enfant
          // validation_groups, translation_domain
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'europa_blogbundle_post';
    }
}
