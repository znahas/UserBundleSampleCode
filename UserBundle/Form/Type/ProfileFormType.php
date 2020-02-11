<?php

namespace Application\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder
            ->remove('username')
            ->add('firstname', null, array('label' => 'profile.show.firstname'))
            ->add('lastname', null, array('label' => 'profile.show.lastname'))
            ->add('timezone', 'Symfony\Component\Form\Extension\Core\Type\TimezoneType',
                array('attr' => array('class' => 'combobox'), 'label' => 'profile.show.timezone'))
            ->add('language', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                    'choices' => array('en' => 'language.en', 'fr' => 'language.fr'),
                    'attr'    => array('class' => 'form-control'),
                    'label'   => 'common.language.language'
                )
            );
    }

    public function getName()
    {
        return 'application_user_profile';
    }
}
