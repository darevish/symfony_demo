<?php

namespace darevish\DemoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $token = $this->container->get('security.context')->getToken();

        $menu = $factory->createItem('root');

        $menu->setChildrenAttributes(array('class' => 'nav'));

        $menu->addChild('Home', array('route' => 'default_index'));
        $menu->addChild('About Me', array(
            'route' => 'default_static',
            'routeParameters' => array('template' => 'about')
        ));

        if (!$token || $token instanceof AnonymousToken) {
            $menu->addChild('Login', array('route' => 'login'))->setAttribute('class', 'float-right');
            $menu->addChild('Sign up', array('route' => 'signup'))->setAttribute('class', 'float-right');
        } else {
            $menu->addChild('Logout', array('route' => 'logout'))->setAttribute('class', 'float-right');
        }
        // ... add more children

        return $menu;
    }
}
