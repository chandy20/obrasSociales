<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presupuestos
 *
 * @ORM\Table(name="presupuestos", indexes={@ORM\Index(name="IDX_4CF2F0DA46963F6", columns={"idArea"}), @ORM\Index(name="fk_Presupuestos_Areas1_idx", columns={"id"})})
 * @ORM\Entity
 */
class Presupuestos {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PresupuestoMonto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $presupuestomonto;

    /**
     * @var string
     *
     * @ORM\Column(name="saldo", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $saldo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="desde", type="datetime", nullable= true)
     */
    private $desde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hasta", type="datetime", nullable= true)
     */
    private $hasta;

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
     * @var \Seccionales
     *
     * @ORM\ManyToOne(targetEntity="Seccionales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seccional_id", referencedColumnName="id")
     * })
     */
    private $seccional;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set presupuestomonto
     *
     * @param string $presupuestomonto
     *
     * @return Presupuestos
     */
    public function setPresupuestomonto($presupuestomonto) {
        $this->presupuestomonto = $presupuestomonto;

        return $this;
    }

    /**
     * Get presupuestomonto
     *
     * @return string
     */
    public function getPresupuestomonto() {
        return $this->presupuestomonto;
    }

    /**
     * Set idarea
     *
     * @param \AppBundle\Entity\Areas $idarea
     *
     * @return Presupuestos
     */
    public function setIdarea(\AppBundle\Entity\Areas $idarea = null) {
        $this->idarea = $idarea;

        return $this;
    }

    /**
     * Get idarea
     *
     * @return \AppBundle\Entity\Areas
     */
    public function getIdarea() {
        return $this->idarea;
    }


    /**
     * Set saldo
     *
     * @param string $saldo
     *
     * @return Presupuestos
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set desde
     *
     * @param \DateTime $desde
     *
     * @return Presupuestos
     */
    public function setDesde($desde)
    {
        $this->desde = $desde;

        return $this;
    }

    /**
     * Get desde
     *
     * @return \DateTime
     */
    public function getDesde()
    {
        return $this->desde;
    }

    /**
     * Set hasta
     *
     * @param \DateTime $hasta
     *
     * @return Presupuestos
     */
    public function setHasta($hasta)
    {
        $this->hasta = $hasta;

        return $this;
    }

    /**
     * Get hasta
     *
     * @return \DateTime
     */
    public function getHasta()
    {
        return $this->hasta;
    }

    /**
     * Set seccional
     *
     * @param \AppBundle\Entity\Seccionales $seccional
     *
     * @return Presupuestos
     */
    public function setSeccional(\AppBundle\Entity\Seccionales $seccional = null)
    {
        $this->seccional = $seccional;

        return $this;
    }

    /**
     * Get seccional
     *
     * @return \AppBundle\Entity\Seccionales
     */
    public function getSeccional()
    {
        return $this->seccional;
    }
}
