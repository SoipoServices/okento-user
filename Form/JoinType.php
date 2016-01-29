<?php

namespace Soipo\Okento\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('title',ChoiceType::class,array('label' => 'label.title','required'=>false,'placeholder'=>'select.title','choices'=>$this->getTitles()))
            ->add('firstName',TextType::class,array('label' => 'label.firstname','required'=>true))
            ->add('lastName',TextType::class,array('label' => 'label.lastname','required'=>true))
            ->add('email', EmailType::class,array('label' => 'label.email','required'=>true))
            ->add('country',CountryType::class,array('label' => 'label.country','placeholder'=>'select.country','required'=>false))
            ->add('city',TextType::class,array('label' => 'label.city','required'=>false))
            ->add('province',TextType::class,array('label' => 'label.province','required'=>false))
            ->add('postalCode',TextType::class,array('label' => 'label.postalCode','required'=>false))
            ->add('phone',TextType::class,array('label' => 'label.phone','required'=>false))
            ->add('username', TextType::class,array('label' => 'label.username','required'=>true))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'label.password'),
                'second_options' => array('label' => 'label.password.repeat'),
                'required'=>true
            ))
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


    public function getBlockPrefix(){
        return 'join';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'join';
    }
}
