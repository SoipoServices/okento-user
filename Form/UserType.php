<?php

namespace Soipo\Okento\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title','choice',array('label' => 'label.title','placeholder'=>'select.title','required'=>false,'choices'=>$this->getTitles()))
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
                'required' => false
            ))
            ->add('affiliation', 'text',array('label' => 'label.affiliation','required'=>false))
            ->add('association', 'checkbox',array('label' => 'label.association','required'=>false))
            ->add('associationCode', 'text',array('label' => 'label.associationCode','required'=>false))
            ->add('associationProvince', 'text',array('label' => 'label.associationProvince','required'=>false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Soipo\Okento\UserBundle\Entity\User',
            'translation_domain' => 'user',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention'       => 'user'
        ));
    }

    protected function getTitles(){
        return array(
            'mr'=>'choices.title.mr',
            'mrs' => 'choices.title.mrs',
            'miss' => 'choices.title.miss',
            'dr' => 'choices.title.dr',
            'prof' => 'choices.title.prof',
        );
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
