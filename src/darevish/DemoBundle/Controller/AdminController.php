<?php

namespace darevish\DemoBundle\Controller;

use darevish\DemoBundle\Entity\DemoUser;
use darevish\DemoBundle\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AdminController
 * @package darevish\DemoBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin/user", name="user_admin_list")
     * @Template()
     */
    public function listUsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('darevishDemoBundle:DemoUser')->findAll();

        return array(
            'users' => $users,
        );
    }

    /**
     * @Route("/admin/user/{demoUser}/edit", name="user_admin_edit")
     * @Template()
     */
    public function editUserAction(Request $request, DemoUser $demoUser)
    {
        $form = $this->createForm(new UserEditType(), $demoUser);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($demoUser);
            $em->flush();

            /** @var Session $session */
            $session = $this->get('session');
            $session->getFlashBag()->add('success', 'Save successful');

            return $this->redirect($this->generateUrl('user_admin_list'));
        }

        return array(
            'user' => $demoUser,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/admin/user/{demoUser}/delete", name="user_admin_delete")
     */
    public function deleteUserAction(Request $request, DemoUser $demoUser)
    {
        if ($request->getMethod() == "POST")
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demoUser);
            $em->flush();

            /** @var Session $session */
            $session = $this->get('session');

            $securityContext = $this->get("security.context");
            $user = $securityContext->getToken()->getUser();
            if ($user instanceof DemoUser && $user->getId() == $demoUser->getId()) {
                $session->invalidate();
                $securityContext->setToken(null);
            }

            $session->getFlashBag()->add('success', 'Save successful');

        }

        return $this->redirect($this->generateUrl('user_admin_list'));
    }
}
