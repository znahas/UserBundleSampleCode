<?php

namespace Application\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use JMS\DiExtraBundle\Annotation\Observe;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PasswordResettingListener implements EventSubscriberInterface
{
     /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResettingSuccess',
        );
    }

    /**
     * @Observe("kernel.event_subscriber")
     * @param FormEvent $event
     */
    public function onPasswordResettingSuccess(FormEvent $event)
    {
        // Redirect to homepage after reset password
        $url = $this->router->generate('homepage');

        $event->setResponse(new RedirectResponse($url));
    }
}
