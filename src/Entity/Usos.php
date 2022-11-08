<?php

namespace App\Entity;
use App\Repository\UsosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Stringable;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * Usos
 */
#[ORM\Table(name: 'usos')]
#[ORM\Entity(repositoryClass: UsosRepository::class)]
class Usos implements Stringable
{
    #[ORM\Column(name: 'ID', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[Groups('basic')]
    private ?int $id = null;

    #[ORM\Column(name: 'Nombre', type: 'string', length: 255, nullable: true)]
    // #[Groups('basic')]
     #[Groups(['form_planta', 'basic'])]
    private ?string $nombre = null;

    
    #[ORM\ManyToMany(targetEntity: 'Planta', mappedBy: 'uso')]
    #[Groups('basic')]
    private Collection $planta ;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->planta = new ArrayCollection();
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
     * @return Collection
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

    public function __toString(): string
    {

        return (string) $this->nombre;
    }

}
