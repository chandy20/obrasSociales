<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movimiento
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MovimientoRepository")
 */
class Movimiento {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    private $tipo;
    
     /**
     * @var \Solicitudes
     *
     * @ORM\ManyToOne(targetEntity="Conceptosjunta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="concepto_junta_id", referencedColumnName="id")
     * })
     */
    private $concepto;
    
     /**
     * @var \Solicitudes
     *
     * @ORM\ManyToOne(targetEntity="Seccionales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seccional_id", referencedColumnName="id")
     * })
     */
    private $seccional;
    
     /**
     * @var \Solicitudes
     *
     * @ORM\ManyToOne(targetEntity="Presupuestos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="presupuesto_id", referencedColumnName="id")
     * })
     */
    private $presupuesto;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     *
     * @return Movimiento
     */
    public function setValor($valor) {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Movimiento
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo() {
        return $this->tipo;
    }


    /**
     * Set concepto
     *
     * @param \AppBundle\Entity\Conceptosjunta $concepto
     *
     * @return Movimiento
     */
    public function setConcepto(\AppBundle\Entity\Conceptosjunta $concepto = null)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \AppBundle\Entity\Conceptosjunta
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set seccional
     *
     * @param \AppBundle\Entity\Seccionales $seccional
     *
     * @return Movimiento
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

    /**
     * Set presupuesto
     *
     * @param \AppBundle\Entity\Presupuestos $presupuesto
     *
     * @return Movimiento
     */
    public function setPresupuesto(\AppBundle\Entity\Presupuestos $presupuesto = null)
    {
        $this->presupuesto = $presupuesto;

        return $this;
    }

    /**
     * Get presupuesto
     *
     * @return \AppBundle\Entity\Presupuestos
     */
    public function getPresupuesto()
    {
        return $this->presupuesto;
    }
}
