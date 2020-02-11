<?php

namespace Application\UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Application\UserBundle\Entity\User;

/**
 * @Route("/admin/users/cr")
 */
class UserCRController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     * @Secure(roles="ROLE_MOD_USER_READ")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $badges = $em->getRepository('ApplicationUserBundle:User')->getCountByStatus();

        $show = $request->query->get('show', 'admin');

        // Show soft deleted users
        $filters = $em->getFilters();
        $filters->disable('softdeleteable');


        if ($show == 'all') {
            /** @var User[] $users */
            $users = $em->getRepository('ApplicationUserBundle:User')->findAll();
        } else {

            switch ($show) {
                case 'inclan':
                    break;
                case 'noclan':
                    $users = $em->getRepository('ApplicationUserBundle:User')->findBy(array(
                        'clan' => null,
                    ));
                    break;
                case 'tracked':
                    $users = $em->getRepository('ApplicationUserBundle:User')->findBy(array(
                        'isTracked' => true,
                    ));
                    break;
                case 'clan':
                    $role  = '"ROLE_CLAN"';
                    $users = $em->getRepository('ApplicationUserBundle:User')->getAllByRole($role)->getQuery()->getResult();
                    break;
                default:
                    $role  = '"ROLE_ADMIN"';
                    $users = $em->getRepository('ApplicationUserBundle:User')->getAllByRole($role)->getQuery()->getResult();
                    break;
            }


        }

        return array(
            'users'  => $users,
            'badges' => $badges,
            'show'   => $show,
        );
    }


}
