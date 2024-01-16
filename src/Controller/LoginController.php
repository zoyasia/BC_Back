<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;

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

}