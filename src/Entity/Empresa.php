<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity
 * @OA\Schema(
 *     title="Empresa",
 *     description="Entidade que representa Empresa"
 * )
 */
#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[Groups('Api_list')]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('Api_list')]
    private ?int $id = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Groups('Api_list')]
    private ?string $nome = null;

    #[ORM\Column(nullable: true)]
    #[Groups('Api_list')]
    private ?int $cnpj = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Groups('Api_list')]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Groups('Api_list')]
    private ?string $contato = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[Groups('Api_list')]
    private ?string $endereco = null;

    #[ORM\OneToMany(targetEntity: "App\Entity\Socio", mappedBy: "empresa", cascade: ["remove"])]
    #[Groups('Api_list', 'api_exclude_socios')]
    private $socios;


    public function __construct()
    {
        $this->socios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getContato(): ?string
    {
        return $this->contato;
    }

    public function setContato(string $contato): self
    {
        $this->contato = $contato;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): self
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Retorna uma lista de Sócios.
     * 
     * @Route("/empresa", methods={"GET"})
     * @OA\Get(
     *     path="/empresa",
     *     summary="Obtém uma lista de Sócios",
     *     tags={"Socios"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna a lista de Sócios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref=@Model(type=User::class))
     *         )
     *     )
     * )
     */

    /**
     * @return ArrayCollection
     */
    public function getSocios()
    {
        return $this->socios;
    }

    public function addSocio(Socio $socio): self
    {
        if (!$this->socios->contains($socio)) {
            $this->socios[] = $socio;
            $socio->setEmpresa($this);
        }

        return $this;
    }

    public function removeSocio(Socio $socio): self
    {
        if ($this->socios->removeElement($socio)) {
            if ($socio->getEmpresa() === $this) {
                $socio->setEmpresa(null);
            }
        }

        return $this;
    }
}
