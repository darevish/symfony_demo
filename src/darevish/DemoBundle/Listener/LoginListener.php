<?php

namespace darevish\DemoBundle\Listener;

use darevish\DemoBundle\Entity\DemoUser;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof DemoUser) {
            /** @var DemoUser $user */
            $user->setLastLogin(new \DateTime('now'));
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}