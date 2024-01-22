<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => [
                'ROLE_USER' => 'Utilisateur',
                'ROLE_ADMIN' => 'Administrateur',
                'ROLE_SUPER_ADMIN' => 'Super Administrateur',
            ],
            'multiple' => false,
            'expanded' => true, // Affiche les options sous forme de cases à cocher
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
