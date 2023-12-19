<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Request;

class UserManager
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private UserFactory $userFactory;


    public function __construct(
        UserRepository $userRepository, 
        EntityManagerInterface $entityManager,
        UserFactory $userFactory
        )
    {
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

    public function create(string $firstname, string $lastname, string $email, string $password): User
    {

        $user = $this->userFactory->create($firstname, $lastname, $email, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }


    // public function create(string $firstname, string $lastname, string $email, string $password, string $gender, string $address, int $zipcode, string $city): User
    // {

    //     $user = $this->userFactory->createUser($firstname, $lastname, $email, $password, $gender, $address, $zipcode, $city);

    //     $this->entityManager->persist($user);
    //     $this->entityManager->flush();

    //     return $user;
    // }

    // public function update(User $task, array $data): void
    // {
    //     if (!empty($data['title']) && $data['title'] !== $task->getTitle()) {
    //         $task->setTitle($data['title']);
    //     }

    //     if (!empty($data['description']) && $data['description'] !== $task->getDescription()) {
    //         $task->setDescription($data['description']);
    //     }

    //     if (!empty($data['deadline']) && $data['deadline'] !== $task->getDeadline()) {
    //         $task->setDeadline($data['deadline']);
    //     }

    //     if (!empty($data['status']) && $data['status'] !== $task->getStatus()) {
    //         $task->setStatus($data['status']);
    //     }

    //     if ($data['status'] !== $task->isIsCompleted()) {
    //         $task->setIsCompleted($data['isCompleted']);
    //     }

    //     $this->entityManager->persist($task);
    //     $this->entityManager->flush();
    // }

    // public function delete($taskId): User
    // {

    //     $task = $this->userRepository->find($taskId);

    //     if (!$task) {
    //         throw new \Doctrine\ORM\EntityNotFoundException('Tâche non trouvée');
    //     }

    //     $this->entityManager->remove($task);
    //     $this->entityManager->flush();

    //     return $task;
    // }
}