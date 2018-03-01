<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingresos
 *
 * @ORM\Table(name="ingresos")
 * @ORM\Entity
 */
class Ingresos
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
     * @ORM\Column(name="IngresoNombre", type="string", length=150, nullable=false)
     */
    private $ingresonombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="IngresoPuntaje", type="integer", nullable=false)
     */
    private $ingresopuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IngresosEstado", type="boolean", nullable=false)
     */
    private $ingresosestado;

    public function __toString(){
    return (string) $this->getIngresonombre();
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
     * Set ingresonombre
     *
     * @param string $ingresonombre
     *
     * @return Ingresos
     */
    public function setIngresonombre($ingresonombre)
    {
        $this->ingresonombre = $ingresonombre;

        return $this;
    }

    /**
     * Get ingresonombre
     *
     * @return string
     */
    public function getIngresonombre()
    {
        return $this->ingresonombre;
    }

    /**
     * Set ingresopuntaje
     *
     * @param integer $ingresopuntaje
     *
     * @return Ingresos
     */
    public function setIngresopuntaje($ingresopuntaje)
    {
        $this->ingresopuntaje = $ingresopuntaje;

        return $this;
    }

    /**
     * Get ingresopuntaje
     *
     * @return integer
     */
    public function getIngresopuntaje()
    {
        return $this->ingresopuntaje;
    }

    /**
     * Set ingresosestado
     *
     * @param boolean $ingresosestado
     *
     * @return Ingresos
     */
    public function setIngresosestado($ingresosestado)
    {
        $this->ingresosestado = $ingresosestado;

        return $this;
    }

    /**
     * Get ingresosestado
     *
     * @return boolean
     */
    public function getIngresosestado()
    {
        return $this->ingresosestado;
    }
}
