<?php

namespace App\Entity;
use App\Repository\InfocomercialRepository;
use App\Entity\Herbolario;
use App\Entity\Planta;
use Doctrine\ORM\Mapping as ORM;

/**
 * Infocomercial
 */
#[ORM\Table(name: 'infocomercial')]
#[ORM\Index(name: 'FKInfoComerc79765', columns: ['PlantaID'])]
#[ORM\Index(name: 'FKInfoComerc148513', columns: ['HerbolarioID'])]
#[ORM\Entity(repositoryClass: InfocomercialRepository::Class)]
class Infocomercial
{
    #[ORM\Column(name: 'id_comercial', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private readonly int $idComercial;

    #[ORM\Column(name: 'Precio', type: 'float', precision: 10, scale: 0, nullable: false)]
    private ?float $precio = null;

    #[ORM\JoinColumn(name: 'HerbolarioID', referencedColumnName: 'ID')]
    #[ORM\ManyToOne(targetEntity: 'Herbolario')]
    private ?Herbolario $herbolarioid = null;

    #[ORM\JoinColumn(name: 'PlantaID', referencedColumnName: 'ID')]
    #[ORM\ManyToOne(targetEntity: 'Planta')]
    private ?Planta $plantaid = null;

    public function getIdComercial(): ?int
    {
        return $this->idComercial;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getHerbolarioid(): ?Herbolario
    {
        return $this->herbolarioid;
    }

    public function setHerbolarioid(?Herbolario $herbolarioid): self
    {
        $this->herbolarioid = $herbolarioid;

        return $this;
    }

    public function getPlantaid(): ?Planta
    {
        return $this->plantaid;
    }

    public function setPlantaid(?Planta $plantaid): self
    {
        $this->plantaid = $plantaid;

        return $this;
    }


}
