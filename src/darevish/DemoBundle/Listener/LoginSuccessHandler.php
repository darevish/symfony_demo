<?php

namespace darevish\DemoBundle\Listener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $securityContext;

    private $router;

    private $cookieName;

    function __construct(RouterInterface $router, SecurityContext $securityContext, $cookieName)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
        $this->cookieName = $cookieName;
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
        if ($this->securityContext->isGranted('ROLE_ADMIN')) {
            $uri = $this->router->generate('user_admin_list');
        } else {
            $uri = $this->router->generate('default_index');
        }

        $response = new RedirectResponse($uri);

        $response->headers->setCookie(new Cookie($this->cookieName, $token->getUsername(), new \DateTime('+1 day')));

        return $response;
    }
}