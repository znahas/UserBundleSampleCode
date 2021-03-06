<?php

namespace Application\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Application\UserBundle\Entity\User;
use Application\UserBundle\Form\Type\OverwritePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;


class ResetAdminController extends Controller
{
    /**
     * @Route("/reset-password/{username}")
     *
     * @Secure(roles="ROLE_MOD_USER_WRITE")
     * @param $username
     * @return RedirectResponse
     */
    public function resetPasswordAction($username)
    {
        /** @var $user UserInterface */
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            $this->get('session')->getFlashBag()->add('danger', 'User don\'t exist.');
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            $this->get('session')->getFlashBag()->add('danger', 'Password Already Requested.');
        }

        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch('application.user.password.reset_process_started', new GenericEvent('', array('username' => $username)));

        $this->get('session')->getFlashBag()->add('success', 'Reset password email has been sent.');

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }


    /**
     * @Route("/overwrite-password/{id}", requirements={"id" = "\d+"})
     * @Secure(roles="ROLE_MOD_USER_WRITE")
     * @Template()
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function overwritePasswordAction(Request $request, User $user)
    {
        $form = $this->createForm(new OverwritePasswordFormType('Application\UserBundle\Entity\User'), $user);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $this->get('fos_user.user_manager')->updateUser($user);

                $dispatcher = $this->container->get('event_dispatcher');
                $dispatcher->dispatch('application.user.password.overwrite', new GenericEvent('', array('user' => $user)));

                $this->get('session')->getFlashBag()->add('success', 'Password has been changed.');
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
