<?php

namespace Burgov\Bundle\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType {

    public function getName() {
        return 'burgov_contact';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', null, array(
            'label' => 'Naam',
            'constraints' => new \Symfony\Component\Validator\Constraints\MinLength(6)
        ));
        $builder->add('email', 'email', array(
            'label' => 'E-mailadres',
            'constraints' => new \Symfony\Component\Validator\Constraints\Email
        ));
        $builder->add('message', 'textarea', array(
            'label' => 'Uw bericht',
            'constraints' => new \Symfony\Component\Validator\Constraints\NotBlank,
            'attr' => array(
                'cols' => 50,
                'rows' => 5
            )
        ));
    }

}

