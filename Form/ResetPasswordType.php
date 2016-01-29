<?php

namespace Soipo\Okento\UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends UserType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class,array('label' => 'label.username','required'=>true))
            ->add('_email', EmailType::class,array('label' => 'label.email','required'=>true));
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
            'intention'       => 'resetPassword'
        ));
    }

    public function getBlockPrefix(){
        return 'resetPassword';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'resetPassword';
    }
}
