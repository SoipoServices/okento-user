<?php

namespace Soipo\Okento\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends UserType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class,array('label' => 'label.username','trim'=>true))
            ->add('_password', PasswordType::class,array('label' => 'label.password','trim'=>true))
            ->add('_remember_me', CheckboxType::class,array('label' => 'label.remember.me','required'=>false));
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'security',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'authenticate'
        ));
    }

    public function getBlockPrefix(){
        return '';
    }
    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
