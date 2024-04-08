<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use App\Repository\EmpresaRepository;
use App\Repository\SocioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="LoginController",
 *     description="Controlador responsável por listar e alterar os dados da Empresa."
 * )
 */
class EmpresaController extends AbstractController
{
    #[Route('/empresa', name: 'empresa_index')]
    public function index(): Response
    {        
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $empresas = $this->getDoctrine()->getRepository(Empresa::class)->findAll();
        return $this->render('empresa/index.html.twig', [
            'empresa' => $empresas,
        ]);
    }

    #[Route('/new', name: 'empresa_new')]
    public function new(Request $request): Response
    {
        $msgErro = '';
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($empresa);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $msgErro = 'Ocorreu um erro ao tentar salvar a empresa. Por favor, tente novamente mais tarde.';                
            }

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('empresa/new.html.twig', [
            'form'    => $form->createView(),
            'msgErro' => $msgErro
        ]);
    }


    #[Route('/{id}/edit', name: 'empresa_edit')]
    public function editar(Request $request, Empresa $empresa): Response
    {
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }

            return $this->redirectToRoute('empresa_index');
        }

        return $this->render('empresa/editar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'empresa_delete')]
    public function excluirEmpresa($id, EntityManagerInterface $entityManager, EmpresaRepository $empresaRepository, SocioRepository $socioRepository): Response
    {
        $empresa = $empresaRepository->findEmpresaById($id);

        if (!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }
        // Busca os sócios relacionados à empresa
        $socios = $socioRepository->findBy(['empresa' => $empresa]);

        // Remove os sócios associados à empresa
        foreach ($socios as $socio) {
            $entityManager->remove($socio);
        }

        $entityManager->remove($empresa);
        $entityManager->flush();

        return $this->redirectToRoute('empresa_index');
    }
}
