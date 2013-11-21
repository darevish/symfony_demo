<?php

namespace darevish\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * Class DefaultController
 * @package darevish\DemoBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="default_index")
     * @Template()
     */
    public function indexAction()
    {
        $token = $this->get('security.context')->getToken();
        $isRealToken = !$token || $token instanceof AnonymousToken;

        if ($isRealToken) {
            $username = 'Visitor';
        } else {
            $username = $token->getUser()->getUsername();
        }

        $em = $this->getDoctrine()->getManager();
        $registerdUsers = $em->getRepository('darevishDemoBundle:DemoUser')->findAll();

        return array(
            'name'             => $username,
            'is_real_token'    => $isRealToken,
            'registered_users' => $registerdUsers
        );
    }

    /**
     * @Route("/static/{template}", name="default_static")
     * @Template()
     */
    public function staticAction($template)
    {
        return $this->render('darevishDemoBundle:Static:' . $template . '.html.twig');
    }
}
