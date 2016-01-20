<?php

namespace Soipo\Okento\UserBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoinType extends UserType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','choice',array('label' => 'label.title','required'=>false,'placeholder'=>'select.title','choices'=>$this->getTitles()))
            ->add('firstName','text',array('label' => 'label.firstname','required'=>true))
            ->add('secondName','text',array('label' => 'label.secondname','required'=>false))
            ->add('lastName','text',array('label' => 'label.lastname','required'=>true))
            ->add('email', 'email',array('label' => 'label.email','required'=>true))
            ->add('country','country',array('label' => 'label.country','placeholder'=>'select.country','required'=>false))
            ->add('city','text',array('label' => 'label.city','required'=>false))
            ->add('province','text',array('label' => 'label.province','required'=>false))
            ->add('postalCode','text',array('label' => 'label.postalCode','required'=>false))
            ->add('phone','text',array('label' => 'label.phone','required'=>false))
            ->add('username', 'text',array('label' => 'label.username','required'=>true))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'label.password'),
                'second_options' => array('label' => 'label.password.repeat'),
                'required'=>true
            ))
            ->add('affiliation', 'text',array('label' => 'label.affiliation','required'=>false))
            ->add('association', 'checkbox',array('label' => 'label.association','required'=>false))
            ->add('associationCode', 'text',array('label' => 'label.associationCode','required'=>false))
            ->add('associationProvince', 'text',array('label' => 'label.associationProvince','required'=>false))
            //->add('terms',null,array('label'=>'label.terms'))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(array(
            'translation_domain' => 'security',
            'intention'       => 'registration'
        ));
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'join';
    }
}
