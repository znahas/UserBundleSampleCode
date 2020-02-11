<?php

namespace Application\UserBundle\Tools;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Role
{
    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @return array
     */
    public static function getRolesList(AuthorizationCheckerInterface $authorizationChecker)
    {
        $roles = array(
            'ROLE_CLAN',
            'ROLE_CLAN_ADMIN',
            'ROLE_ACCOUNTING',
            'ROLE_DESIGNER',
            'ROLE_DEVELOPPER',
            'ROLE_PROJECTMANAGER',
            'ROLE_USER_NPS',
        );

        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            $roles[] = 'ROLE_OPERATION';
        }

        if ($authorizationChecker->isGranted('ROLE_ADMIN')) {
            $roles[] = 'ROLE_ADMIN';
        }

        asort($roles);

        return $roles;
    }
}
