<?php

namespace Application\UserBundle\EventListener;

use Application\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class ForcePassUpdateListener
{
    private $authorizationChecker, $tokenStorage, $router, $session;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage, SessionInterface $session, RouterInterface $router)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage         = $tokenStorage;
        $this->router               = $router;
        $this->session              = $session;
    }

    /**
     * @param GetResponseEvent $event
     * @throws \Exception
     */
    public function onCheckExpired(GetResponseEvent $event)
    {
        if (($this->tokenStorage->getToken()) && ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_FULLY'))) {

            $route_name = $event->getRequest()->get('_route');

            if ($route_name && $route_name != 'fos_user_change_password') {

                $pass_validity_days = 90;

                $today = new \DateTime();
                /** @var $user User */
                $user = $this->tokenStorage->getToken()->getUser();

                $days_since_last_change = $user->getPasswordChangedAt()->diff($today);

                if ($days_since_last_change->format('%a') > $pass_validity_days) {

                    $response = new RedirectResponse($this->router->generate('fos_user_change_password'));
                    $this->session->getFlashBag()->add('warning', "Your password has expired. Please change it");

                    $event->setResponse($response);
                }
            }
        }
    }
}
