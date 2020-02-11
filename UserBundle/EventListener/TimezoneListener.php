<?php

namespace Application\UserBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Observe;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Inject;

/**
 * @Service
 */
class TimezoneListener
{

    private $securityContext;

    /**
     * @InjectParams({
     *     "securityContext" = @Inject("security.authorization_checker"),
     *     "tokenStorage" = @Inject("security.token_storage")
     * })
     *
     * @param AuthorizationCheckerInterface $securityContext
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(AuthorizationCheckerInterface $securityContext, TokenStorageInterface $tokenStorage)
    {
        $this->securityContext = $securityContext;
        $this->tokenStorage    = $tokenStorage;
    }

    /**
     * @Observe("kernel.request")
     */
    public function onKernelRequest()
    {
        try {
            if (!$this->securityContext->isGranted('ROLE_USER')) {
                return;
            }

            $user = $this->tokenStorage->getToken()->getUser();

            if ($user) {
                if (!$user->getTimezone()) {
                    return;
                }

                date_default_timezone_set($user->getTimezone());
            }
        } catch (\Exception $e) {
        }
    }
}
