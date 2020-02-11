<?php

namespace Application\UserBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Mailer\TwigSwiftMailer;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class UserCreateListener
{
    protected $userManager, $mailer, $tokenGenerator, $em;

    public function __construct(EntityManagerInterface $em, UserManagerInterface $userManager, TwigSwiftMailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $this->em             = $em;
        $this->userManager    = $userManager;
        $this->mailer         = $mailer;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function onEvent(GenericEvent $event)
    {
        // Create User
        $user = $event->getArgument('user');

        $user->setEnabled(false);
        $user->setPassword(md5(uniqid(rand(), true))); // Temp password

        // Add roles
        $user->addRole("ROLE_USER");

        // Save User
        $this->userManager->updateUser($user);

        // Send confirmation email
        if (null === $user->getConfirmationToken()) {
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
        }

        $this->mailer->sendConfirmationEmailMessage($user);

        // Start Reset Password Process
        $event->getDispatcher()->dispatch('application.user.password.reset_process_started', new GenericEvent('', array(
            'username' => $user->getUsername()
        )));
    }
}
