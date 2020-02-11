<?php

namespace Application\UserBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Jmikola\WildcardEventDispatcher\WildcardEventDispatcher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\EventDispatcher\GenericEvent;
use Application\UserBundle\Entity\User;

/**
 * @Route("/admin/users")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     *
     * @Template()
     * @Secure(roles="ROLE_MOD_USER_READ")
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        /** @var $em ObjectManager */
        $em = $this->getDoctrine()->getManager();

        $badges = $em->getRepository('ApplicationUserBundle:User')->getCountByStatus();

        $show = $request->query->get('show', 'admin');

        // Show soft deleted users
        $filters = $em->getFilters();
        $filters->disable('softdeleteable');


        if ($show == 'all') {
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

    /**
     * @Route("/new")
     *
     * @Template("ApplicationUserBundle:Admin:edit.html.twig")
     * @Secure(roles="ROLE_MOD_USER_WRITE")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Application\UserBundle\Form\Type\UserFormType', $user, array(
                'authorizationChecker' => $this->get('security.authorization_checker')
            )
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                /** @var WildcardEventDispatcher $dispatcher */
                $dispatcher = $this->container->get('event_dispatcher');
                $dispatcher->dispatch('application.user.created', new GenericEvent('', array('user' => $user)));

                $this->get('session')->getFlashBag()->add('success', 'User created.');

                return $this->redirect($this->generateUrl('application_user_admin_index'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{user}")
     *
     * @Template()
     * @Secure(roles="ROLE_MOD_USER_WRITE")
     * @param User $user
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function editAction(User $user, Request $request)
    {
        /** @var $em ObjectManager */
        $em = $this->getDoctrine()->getManager();

//        $form = $this->createForm(new UserFormType($this->get('security.authorization_checker')), $user);
        $form = $this->createForm('Application\UserBundle\Form\Type\UserFormType', $user,
            array('authorizationChecker' => $this->get('security.authorization_checker')));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'User saved.');

                $referer = $request->headers->get('referer');

                return new RedirectResponse($referer);
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/delete/{username}")
     *
     * @ Template()
     * @Secure(roles="ROLE_MOD_USER_WRITE")
     * @return RedirectResponse
     */
    public function deleteAction()
    {
        //$this->get('session')->getFlashBag()->add('success', 'User '.$username.' deleted');
        // TODO: soft delete
        $this->get('session')->getFlashBag()->add('danger', "Function not implemented. Can't delete a user.");

        return $this->redirect($this->generateUrl('application_user_admin_index'));
    }
}
