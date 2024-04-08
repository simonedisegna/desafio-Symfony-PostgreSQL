<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="Socio",
 *     description="Entidade que representa Socio"
 * )
 */

#[ORM\Entity(repositoryClass: SocioRepository::class)]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('Api_list')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('Api_list')]
    private ?string $nome = null;

    #[ORM\Column]
    #[Groups('Api_list')]
    private ?int $cpf = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups('Api_list')]
    private ?string $contato = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('Api_list')]
    private ?string $email = null;

  
    #[ORM\ManyToOne(targetEntity: "App\Entity\Empresa", inversedBy: "socios")]
    #[ORM\JoinColumn(name: "empresa_id", referencedColumnName: "id")]
    
    private Empresa $empresa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCpf(): ?int
    {
        return $this->cpf;
    }

    public function setCpf(int $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getContato(): ?string
    {
        return $this->contato;
    }

    public function setContato(?string $contato): static
    {
        $this->contato = $contato;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmpresa(): Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(Empresa $empresa): void
    {
        $this->empresa = $empresa;
    }
}
