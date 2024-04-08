<?php

namespace App\Controller;

use App\Repository\EmpresaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="LoginController",
 *     description="Controlador responsável por lidar com a autenticação e autorização de usuários na API do sistema."
 * )
 */
class ApiController extends AbstractController
{
    #[Route('/api/empresas', name: 'app_api', methods: ['GET'])]
    public function empresa(EmpresaRepository $empresaRepository, SerializerInterface $serializer): JsonResponse
    {
        $empresas = $empresaRepository->findAll();

        $data = $serializer->serialize($empresas, 'json', [
            'groups' => ['Api_list'],
        ]);

        return new JsonResponse($data, 200, [], true);
    }
}
