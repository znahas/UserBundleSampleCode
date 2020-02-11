<?php

namespace Application\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Application\UserBundle\Tools\Role;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $authorizationChecker = $options['authorizationChecker'];

        $roles = Role::getRolesList($authorizationChecker);

        $builder
            ->add('username')
            ->add('tag')
            ->add('firstname')
            ->add('lastname')
//            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType')
//            ->add('email')
            ->add('phone')
//            ->add('clan')
            ->add('enabled', CheckboxType::class, array('required' => false))
            ->add('isTracked', CheckboxType::class, array('required' => false))
            ->add('roles', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'choices'  => array_combine($roles, $roles),
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ));
    }

    public function getName()
    {
        return 'application_user';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'           => 'Application\UserBundle\Entity\User',
                'authorizationChecker' => null,
            )
        );
    }
}
