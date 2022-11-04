<?php

namespace App\Entity;
use App\Repository\PlantaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Planta
 *
 * @ORM\Table(name="planta")
 * @ORM\Entity(repositoryClass=PlantaRepository::Class)
 */
class Planta
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="Especie", type="string", length=100, nullable=true)
     */
    private $especie;

    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=100, nullable=false)
     */
    #[Groups(['basic'])]
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Lugar", type="string", length=255, nullable=true)
     */
    private $lugar;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Usos", inversedBy="planta")
     * @ORM\JoinTable(name="plantasusos",
     *   joinColumns={
     *     @ORM\JoinColumn(name="Planta", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="Uso", referencedColumnName="ID")
     *   }
     * )
     */
   
    private $uso = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uso = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getEspecie(): ?string
    {
        return $this->especie;
    }

    public function setEspecie(?string $especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function setLugar(?string $lugar): self
    {
        $this->lugar = $lugar;

        return $this;
    }

    /**
     * @return Collection<int, Usos>
     */
    public function getUso(): Collection
    {
        return $this->uso;
    }

    public function addUso(Usos $uso): self
    {
        if (!$this->uso->contains($uso)) {
            $this->uso->add($uso);
        }

        return $this;
    }

    public function removeUso(Usos $uso): self
    {
        $this->uso->removeElement($uso);

        return $this;
    }

}
