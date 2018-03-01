<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Viabilidadplaneacion
 *
 * @ORM\Table(name="viabilidadplaneacion")
 * @ORM\Entity
 */
class Viabilidadplaneacion
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
     * @var string
     *
     * @ORM\Column(name="ViabilidadPlaneacionConcepto", type="string", length=45, nullable=false)
     */
    private $viabilidadplaneacionconcepto;

    /**
     * @var integer
     *
     * @ORM\Column(name="ViabilidadPlaneacionPuntaje", type="integer", nullable=false)
     */
    private $viabilidadplaneacionpuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ViabilidadPlaneacionEstado", type="boolean", nullable=false)
     */
    private $viabilidadplaneacionestado;

public function __toString(){
    return (string) $this->getViabilidadplaneacionconcepto();
}

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
     * Set viabilidadplaneacionconcepto
     *
     * @param string $viabilidadplaneacionconcepto
     *
     * @return Viabilidadplaneacion
     */
    public function setViabilidadplaneacionconcepto($viabilidadplaneacionconcepto)
    {
        $this->viabilidadplaneacionconcepto = $viabilidadplaneacionconcepto;

        return $this;
    }

    /**
     * Get viabilidadplaneacionconcepto
     *
     * @return string
     */
    public function getViabilidadplaneacionconcepto()
    {
        return $this->viabilidadplaneacionconcepto;
    }

    /**
     * Set viabilidadplaneacionpuntaje
     *
     * @param integer $viabilidadplaneacionpuntaje
     *
     * @return Viabilidadplaneacion
     */
    public function setViabilidadplaneacionpuntaje($viabilidadplaneacionpuntaje)
    {
        $this->viabilidadplaneacionpuntaje = $viabilidadplaneacionpuntaje;

        return $this;
    }

    /**
     * Get viabilidadplaneacionpuntaje
     *
     * @return integer
     */
    public function getViabilidadplaneacionpuntaje()
    {
        return $this->viabilidadplaneacionpuntaje;
    }

    /**
     * Set viabilidadplaneacionestado
     *
     * @param boolean $viabilidadplaneacionestado
     *
     * @return Viabilidadplaneacion
     */
    public function setViabilidadplaneacionestado($viabilidadplaneacionestado)
    {
        $this->viabilidadplaneacionestado = $viabilidadplaneacionestado;

        return $this;
    }

    /**
     * Get viabilidadplaneacionestado
     *
     * @return boolean
     */
    public function getViabilidadplaneacionestado()
    {
        return $this->viabilidadplaneacionestado;
    }
}
