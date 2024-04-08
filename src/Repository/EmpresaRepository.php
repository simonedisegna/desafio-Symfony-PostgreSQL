<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Empresa>
 *
 * @method Empresa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Empresa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Empresa[]    findAll()
 * @method Empresa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpresaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empresa::class);
    }

    public function findEmpresaById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findSociosByEmpresaId(int $empresaId): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.socios', 's') // 'socios' é o nome do atributo que representa a relação na entidade Empresa
            ->where('e.id = :empresaId')
            ->setParameter('empresaId', $empresaId)
            ->getQuery()
            ->getResult();
    }
}
