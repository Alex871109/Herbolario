<?php

namespace App\Entity;
use App\Repository\InfocomercialRepository;
use App\Entity\Herbolario;
use App\Entity\Planta;
use Doctrine\ORM\Mapping as ORM;

/**
 * Infocomercial
 *
 * @ORM\Table(name="infocomercial", indexes={@ORM\Index(name="FKInfoComerc79765", columns={"PlantaID"}), @ORM\Index(name="FKInfoComerc148513", columns={"HerbolarioID"})})
 * @ORM\Entity(repositoryClass=InfocomercialRepository::Class)
 */
class Infocomercial
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_comercial", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idComercial;

    /**
     * @var float
     *
     * @ORM\Column(name="Precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var Herbolario
     *
     * @ORM\ManyToOne(targetEntity="Herbolario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HerbolarioID", referencedColumnName="ID")
     * })
     */
    private $herbolarioid;

    /**
     * @var Planta
     *
     * @ORM\ManyToOne(targetEntity="Planta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PlantaID", referencedColumnName="ID")
     * })
     */
    private $plantaid;

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
