<?php

namespace Application\UserBundle\EventListener;

use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class LocaleListener
{

    protected $container;
    protected $availableLocales;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        // todo: put in config.yml
        $this->availableLocales = array('en', 'fr');
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $locale  = $request->getPreferredLanguage($this->availableLocales);

        /** @var TokenInterface $token */
        $token = $this->container->get('security.token_storage')->getToken();
        if (is_object($token)) {
            $user = $token->getUser();
            if (is_a($user, 'FOS\UserBundle\Model\User')) {
                $locale = $user->getLocale();
            }
        }

        $session = $this->container->get('session');
        $session->set('_locale', $locale);
        $request->setLocale($locale);
    }
}
