<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use App\Repository\SocioRepository;
use App\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="LoginController",
 *     description="Controlador responsável por listar e alterar os dados da Sócios."
 * )
 */
class SocioController extends AbstractController
{
    private $socioRepository;
    private $entityManager;

    public function __construct(SocioRepository $socioRepository,EntityManagerInterface $entityManager)
    {
        $this->socioRepository = $socioRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/socio/{id}', name: 'socio_index')]
    public function index($id, Empresa $empresa): Response
    {       
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $socios = $this->socioRepository->findByEmpresaId($id);      
        if (!empty($socios)) {
            $empresa = $socios[0]->getEmpresa();
            $nome_empresa = $empresa->getNome();
        }else{
            $nome_empresa = $this->socioRepository->findCompanyNameById($id);           
        } 
              
        return $this->render('socio/index.html.twig', [
            'socios'     => $socios,
            'empresa'    => $nome_empresa,
            'empresa_id' => $id
        ]);
    }

    #[Route('/socio/new/{id}', name: 'socio_new')]
    public function new($id, Request $request, EntityManagerInterface $entityManager) : Response
    {
        
        $msgErro = '';
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        
        $entityManager = $entityManager;
        $empresa =  $entityManager->getRepository(Empresa::class)->find($id);

        if (!$empresa) {
            throw $this->createNotFoundException('Empresa não encontrada');
        }

        $socio = new Socio();
        $socio->setEmpresa($empresa);

        $form = $this->createForm(SocioType::class, $socio, [
            'empresa_id' => $id,
        ]);

        $data['titulo'] = 'Adiciona novo sócio';
        $data['form']   = $form;
        $data['id']     = $id;

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($socio);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $msgErro = 'Ocorreu um erro ao tentar salvar a empresa. Por favor, tente novamente mais tarde.';
            }

            return $this->redirectToRoute('socio_index', ['id' => $id]);
        }
        
        return $this->render('socio/new.html.twig', $data);
    }

    #[Route('socio/{id}/edit/', name: 'socio_edit')]
    public function edit($id,Request $request, Socio $socio, EntityManagerInterface $entityManager): Response
    {       
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $data = []; 
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $form = $this->createForm(SocioType::class, $socio);
        $idEmpresa = $socio->getEmpresa()->getId();

        $data['titulo'] = 'Editar sócio';
        $data['form']   = $form;       
        $data['id']     = $idEmpresa;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($socio);
            try {
                $entityManager->flush();
            } catch (\Exception $e) {
                $msgErro = 'Ocorreu um erro ao tentar salvar a empresa. Por favor, tente novamente mais tarde.';
            }

            return $this->redirectToRoute('socio_index', ['id' => $idEmpresa]);
        }

        return $this->render('socio/edit.html.twig', $data);
    }

    #[Route('socio/{id}/excluir/', name: 'socio_excluir')]
    public function excluir($id, EntityManagerInterface $entityManager, Socio $socio): Response
    {       
        if ($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN')) {}else{throw new AccessDeniedException('Acesso negado.');}
        $idEmpresa = $socio->getEmpresa()->getId();

        // Encontra o sócio com base no ID
        $socioExcluido = $this->socioRepository->findSocioById($id);

        if (!$socioExcluido) {
            throw $this->createNotFoundException('Sócio não encontrado');
        }      
      
        $entityManager->remove($socioExcluido);
        $entityManager->flush();
        //redireciona para página de socios
        return $this->redirectToRoute('socio_index', ['id' => $idEmpresa]);
    }
}

