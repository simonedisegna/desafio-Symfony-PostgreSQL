<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="LoginController",
 *     description="Controlador responsável por lidar com a autenticação e login dos usuários na aplicação."
 * )
 */
class LoginController extends AbstractController
{
    #[Route('/', name: 'login_index')]
    public function index(AuthenticationUtils $authUtils): Response
    {
        //pegar o erro Login, caso exista
        $erro          = $authUtils->getLastAuthenticationError();
        //pegar o ultimo usuário logado
        $ultimoUsuario = $authUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'erro'          => $erro,
            'ultimoUsuario' => $ultimoUsuario
        ]);
    }

    
}
