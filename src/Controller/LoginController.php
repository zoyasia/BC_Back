<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

// class LoginController extends AbstractController
// {
//     #[Route('/login', name: 'app_login')]
//     public function login(Request $request): JsonResponse
//     {

//         $data = json_decode($request->getContent(), true);
//         $user = $this->getUser();
//         if($data){

//         }
//         return new JsonResponse($data);

//     }
// }


class LoginController extends AbstractController
{

    private JWTTokenManagerInterface $jwtManager;
    private Security $security;

    public function __construct(JWTTokenManagerInterface $jwtManager, Security $security)
    {
        $this->jwtManager = $jwtManager;
        $this->security = $security;
    }

    #[Route(path:'/login', name: 'app_login')]
    public function login(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);


        var_dump($user);

        if (!$user instanceof User) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }

}