<?php

namespace darevish\DemoBundle\Listener;

use darevish\DemoBundle\Entity\DemoUser;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $em;

    private $router;

    function __construct(RouterInterface $router, EntityManager $em)
    {
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param TokenInterface $token
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($token->getUser() instanceof DemoUser) {
            /** @var DemoUser $user */
            $user = $this->em->getRepository('darevishDemoBundle:DemoUser')->loadUserByUserName($token->getUsername());
            $user->setLastLogin(new \DateTime('now'));
            /*
             * temporary, because of erasecredentials
             * todo salt and hash password
             */
            $user->setPassword($user->getUsername() . 'pass');
            $this->em->persist($user);
            $this->em->flush();
        }

        return new RedirectResponse($this->router->generate('default_index'));
    }
}