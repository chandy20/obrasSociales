<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presupuestos
 *
 * @ORM\Table(name="presupuestos", indexes={@ORM\Index(name="IDX_4CF2F0DA46963F6", columns={"idArea"}), @ORM\Index(name="fk_Presupuestos_Areas1_idx", columns={"id"})})
 * @ORM\Entity
 */
class Presupuestos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="PresupuestoAnio", type="integer", nullable=false)
     */
    private $presupuestoanio;

    /**
     * @var string
     *
     * @ORM\Column(name="PresupuestoMonto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $presupuestomonto;

    /**
     * @var \Areas
     *
     * @ORM\ManyToOne(targetEntity="Areas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArea", referencedColumnName="id")
     * })
     */
    private $idarea;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set presupuestoanio
     *
     * @param integer $presupuestoanio
     *
     * @return Presupuestos
     */
    public function setPresupuestoanio($presupuestoanio)
    {
        $this->presupuestoanio = $presupuestoanio;

        return $this;
    }

    /**
     * Get presupuestoanio
     *
     * @return integer
     */
    public function getPresupuestoanio()
    {
        return $this->presupuestoanio;
    }

    /**
     * Set presupuestomonto
     *
     * @param string $presupuestomonto
     *
     * @return Presupuestos
     */
    public function setPresupuestomonto($presupuestomonto)
    {
        $this->presupuestomonto = $presupuestomonto;

        return $this;
    }

    /**
     * Get presupuestomonto
     *
     * @return string
     */
    public function getPresupuestomonto()
    {
        return $this->presupuestomonto;
    }

    /**
     * Set idarea
     *
     * @param \AppBundle\Entity\Areas $idarea
     *
     * @return Presupuestos
     */
    public function setIdarea(\AppBundle\Entity\Areas $idarea = null)
    {
        $this->idarea = $idarea;

        return $this;
    }

    /**
     * Get idarea
     *
     * @return \AppBundle\Entity\Areas
     */
    public function getIdarea()
    {
        return $this->idarea;
    }
}
