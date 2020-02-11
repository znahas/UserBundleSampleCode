<?php

namespace Application\UserBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Mailer\TwigSwiftMailer;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class UserPasswordResetProcessStartListener
{
    protected $userManager,$mailer,$tokenGenerator;

    public function __construct(EntityManagerInterface $em, UserManagerInterface $userManager, TwigSwiftMailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $this->em             = $em;
        $this->userManager    = $userManager;
        $this->mailer         = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function onEvent(GenericEvent $event)
    {
        $username = $event->getArgument('username');

        $user = $this->userManager->findUserByUsernameOrEmail($username);

        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->userManager->updateUser($user);
    }
}
