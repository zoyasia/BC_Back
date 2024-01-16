<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\UserFactory;
use App\State\UserPasswordHasher;

class UserManager
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private UserFactory $userFactory;
    private UserPasswordHasher $passwordHasher;


    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserFactory $userFactory,
        UserPasswordHasher $passwordHasher
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userFactory = $userFactory;
        $this->passwordHasher = $passwordHasher;
    }

    public function getAll(): array
    {
        $users = $this->userRepository->findAll();

        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = $user;
        }

        return $usersArray;
    }

    public function getUserById(int $userId): User
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);
        return $user;
    }

    public function create(string $firstname, string $lastname, string $email, string $password): User
    {

        $user = $this->userFactory->create($firstname, $lastname, $email, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function update(
        User $user,
        ?string $firstname,
        ?string $lastname,
        ?string $email,
        ?string $gender,
        ?string $birthdate,
        ?string $phone,
        ?string $address,
        ?string $zipcode,
        ?string $city,
        ?string $newPassword
    ): User {
        if (!empty($firstname) && $firstname !== $user->getFirstname()) {
            $user->setFirstname($firstname);
        }

        if (!empty($lastname) && $lastname !== $user->getLastname()) {
            $user->setLastname($lastname);
        }

        if (!empty($email) && $email !== $user->getEmail()) {
            $user->setEmail($email);
        }

        if (!empty($gender) && $gender !== $user->getGender()) {
            $user->setGender($gender);
        }

        if (!empty($birthdate) && $birthdate !== $user->getBirthdate()) {
            $user->setBirthdate($birthdate);
        }

        if (!empty($phone) && $phone !== $user->getPhone()) {
            $user->setPhone($phone);
        }

        if (!empty($address) && $address !== $user->getAddress()) {
            $user->setAddress($address);
        }

        if (!empty($zipcode) && $zipcode !== $user->getZipcode()) {
            $user->setZipcode($zipcode);
        }

        if (!empty($city) && $city !== $user->getCity()) {
            $user->setCity($city);
        }

        if (!empty($newPassword)) {
            $user->setPlainPassword($newPassword);
            $this->passwordHasher->hashPassword($user);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}
