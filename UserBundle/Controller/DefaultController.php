<?php

namespace Application\UserBundle\Controller;

use Application\UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/language/switch/{locale}")
     * @param $locale
     * @param Request $request
     * @return RedirectResponse
     */
    public function setAction($locale, Request $request)
    {
        /** @var ObjectManager $em */
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        // instanceof is added because "anon." was returned if there was no user
        if ($user instanceof User) {
            $user->setLanguage($locale);

            $em->persist($user);
            $em->flush();

            //call the dispatcher
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('application.user.language.selected', new GenericEvent('', array('username' => $user->getUsername(), 'locale' => $locale)));
        }

        $redirectTo = $request->headers->get('referer', array('_locale' => $locale));

        return $this->redirect($redirectTo);
    }
}
