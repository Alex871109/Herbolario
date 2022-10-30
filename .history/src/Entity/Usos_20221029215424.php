<?php

namespace App\Entity;
use App\Repository\UsosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;


/**
 * Usos
 *
 * @ORM\Table(name="usos")
 * @ORM\Entity(repositoryClass=UsosRepository::Class)
 */
class Usos
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Planta", mappedBy="uso")
     */
    
    private $planta = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planta = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Planta>
     */
    public function getPlanta(): Collection
    {
        return $this->planta;
    }

    public function addPlantum(Planta $plantum): self
    {
        if (!$this->planta->contains($plantum)) {
            $this->planta->add($plantum);
            $plantum->addUso($this);
        }

        return $this;
    }

    public function removePlantum(Planta $plantum): self
    {
        if ($this->planta->removeElement($plantum)) {
            $plantum->removeUso($this);
        }

        return $this;
    }

    public function __toString()
    {

        return $this->nombre;
    }

}
