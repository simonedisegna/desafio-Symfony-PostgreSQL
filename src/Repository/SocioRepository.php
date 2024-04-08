<?php

namespace App\Repository;

use App\Entity\Socio;
use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SocioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Socio::class);
    }

    public function findByEmpresaId(int $empresaId)
    {
        return $this->createQueryBuilder('socio')
            ->innerJoin('socio.empresa', 'empresa')
            ->andWhere('empresa.id = :empresaId')
            ->setParameter('empresaId', $empresaId)
            ->getQuery()
            ->getResult();
    }
    //função irá retornar o nome da empresa, caso não haja registro na tabela socio
    public function findCompanyNameById($empresaId)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT e.nome 
            FROM App\Entity\Empresa e 
            WHERE e.id = :empresaId'
        )->setParameter('empresaId', $empresaId);

        $empresaName = $query->getOneOrNullResult();

        if (!$empresaName) {
            return null; 
        }

        return $empresaName['nome'];
    }

    public function findSocioById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }
}
