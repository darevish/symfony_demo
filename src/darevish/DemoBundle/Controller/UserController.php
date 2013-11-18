<?php

namespace darevish\DemoBundle\Controller;

use darevish\DemoBundle\Entity\DemoUser;
use darevish\DemoBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class UserController
 * @package darevish\DemoBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/signup", name="signup")
     * @Template()
     */
    public function signUpAction(Request $request)
    {
        $demoUser = new DemoUser();
        $form = $this->createForm(new RegistrationType(), $demoUser);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($demoUser);
            $em->flush();

            /** @var Session $session */
            $session = $this->get('session');

            $token = new UsernamePasswordToken($demoUser, null, 'secured_area', $demoUser->getRoles());
            $this->get('security.context')->setToken($token);
            $this->get('session')->set('_security_secured_area',serialize($token));

            $session->getFlashBag()->add('success', 'Save successful');

            return $this->redirect($this->generateUrl('default_index'));
        }

        return array(
            'form' => $form->createView()
        );
    }
}
