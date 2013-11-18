<?php

namespace darevish\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Username'))
            ->add('email', 'email', array('label' => 'E-mail', 'required' => false))
            ->add('isAdmin', null, array('label' => 'Is admin?', 'required' => false))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat password'),
            ))
            ->add('submit', 'submit', array(
                'attr' => array('class' => 'btn btn-primary'),
                'label' => 'Sign up'
            ));
    }

    public function getName()
    {
        return 'darevishdemobundle_registration';
    }
}
