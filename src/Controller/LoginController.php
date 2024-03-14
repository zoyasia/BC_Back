<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    // #[Route('/login', name: 'login')]
    // public function login(AuthenticationUtils $authenticationUtils): Response
    // {
    //     $error = $authenticationUtils->getLastAuthenticationError();
    //     $lastUsername = $authenticationUtils->getLastUsername();

    //     return $this->render('@EasyAdmin/page/login.html.twig', [
    //         // parameters usually defined in Symfony login forms
    //         'error' => $error,
    //         'last_username' => $lastUsername,

    //         // OPTIONAL parameters to customize the login form:

    //         // the title visible above the login form (define this option only if you are
    //         // rendering the login template in a regular Symfony controller; when rendering
    //         // it from an EasyAdmin Dashboard this is automatically set as the Dashboard title)
    //         'page_title' => 'Frimousse Pressing Authentification',

    //         // // the URL users are redirected to after the login (default: '/admin')
    //         // 'target_path' => $this->generateUrl('/admin'),

    //         // the label displayed for the username form field (the |trans filter is applied to it)
    //         'username_label' => 'Email',

    //         // the label displayed for the password form field (the |trans filter is applied to it)
    //         'password_label' => 'Mot de passe',

    //         // the label displayed for the Sign In form button (the |trans filter is applied to it)
    //         'sign_in_label' => 'Connexion',

    //         // the 'name' HTML attribute of the <input> used for the username field (default: '_username')
    //         'username_parameter' => 'email',

    //         // the 'name' HTML attribute of the <input> used for the password field (default: '_password')
    //         'password_parameter' => 'password',
    //     ]);
    // }

//}

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