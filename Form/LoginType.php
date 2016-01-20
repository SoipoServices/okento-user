<?php

namespace Soipo\Okento\UserBundle\Form;

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
            ->add('_username', 'text',array('label' => 'label.username'))
            ->add('_password', 'password',array('label' => 'label.password'))
            ->add('_remember_me', 'checkbox',array('label' => 'label.remember.me','required'=>false));
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

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
