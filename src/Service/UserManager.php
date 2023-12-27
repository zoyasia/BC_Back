<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\UserFactory;


class UserManager
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private UserFactory $userFactory;


    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserFactory $userFactory
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userFactory = $userFactory;
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


    public function update(User $user, array $data): void
    {
        if (!empty($data['firstname']) && $data['firstname'] !== $user->getFirstname()) {
            $user->setFirstname($data['firstname']);
        }

        if (!empty($data['lastname']) && $data['lastname'] !== $user->getLastname()) {
            $user->setLastname($data['lastname']);
        }

        if (!empty($data['email']) && $data['email'] !== $user->getEmail()) {
            $user->setEmail($data['email']);
        }

        if (!empty($data['gender']) && $data['gender'] !== $user->getGender()) {
            $user->setGender($data['gender']);
        }

        if (!empty($data['birthdate']) && $data['birthdate'] !== $user->getBirthdate()) {
            $user->setBirthdate($data['birthdate']);
        }

        if (!empty($data['address']) && $data['address'] !== $user->getAddress()) {
            $user->setAddress($data['address']);
        }

        if (!empty($data['zipcode']) && $data['zipcode'] !== $user->getZipcode()) {
            $user->setZipcode($data['zipcode']);
        }

        if (!empty($data['city']) && $data['city'] !== $user->getCity()) {
            $user->setCity($data['city']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete($userId): User
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new \Doctrine\ORM\EntityNotFoundException('Utilisateur non trouvé');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $user;
    }
}
