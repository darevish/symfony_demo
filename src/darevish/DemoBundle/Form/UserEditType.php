<?php

namespace darevish\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Username', 'read_only' => true))
            ->add('email', 'email', array('label' => 'E-mail', 'required' => false))
            ->add('isAdmin', null, array('label' => 'Is admin?', 'required' => false))
        ;
    }

    public function getName()
    {
        return 'darevishdemobundle_useredit';
    }
}
