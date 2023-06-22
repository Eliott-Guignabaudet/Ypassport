<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'app_api_login', methods: ['POST'])]
    public function login()
    {
        // return $this->json([
        //     'test' => 'test',
        // ]);
        $user = $this->getUser();
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/api/logout', name: 'app_api_logout', methods: ['POST'])]
    public function logout()
    {
        // controller can be blank: it will never be executed!
    }

}