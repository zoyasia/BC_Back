<?php

namespace App\Factory;

use App\Entity\User;
use App\State\UserPasswordHasher;

class UserFactory
{

    private UserPasswordHasher $passwordHasher;

    public function __construct(UserPasswordHasher $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function create(string $firstname, string $lastname, string $email, string $password): User
    {
        $user = new User();
        $user
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPlainPassword($password)
        ;

        $this->passwordHasher->hashPassword($user);

        return $user;
    }
}
