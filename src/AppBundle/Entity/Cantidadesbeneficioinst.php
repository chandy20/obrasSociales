<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cantidadesbeneficioinst
 *
 * @ORM\Table(name="cantidadesbeneficioinst")
 * @ORM\Entity
 */
class Cantidadesbeneficioinst
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
     * @ORM\Column(name="CantidadesBeneficioDesc", type="string", length=45, nullable=false)
     */
    private $cantidadesbeneficiodesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="CantidadesBeneficioInstPuntaje", type="integer", nullable=false)
     */
    private $cantidadesbeneficioinstpuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CantidadesBeneficioInstEstado", type="boolean", nullable=false)
     */
    private $cantidadesbeneficioinstestado;

public function __toString(){
    return (string) $this->getcantidadesbeneficiodesc();
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
     * Set cantidadesbeneficiodesc
     *
     * @param string $cantidadesbeneficiodesc
     *
     * @return Cantidadesbeneficioinst
     */
    public function setCantidadesbeneficiodesc($cantidadesbeneficiodesc)
    {
        $this->cantidadesbeneficiodesc = $cantidadesbeneficiodesc;

        return $this;
    }

    /**
     * Get cantidadesbeneficiodesc
     *
     * @return string
     */
    public function getCantidadesbeneficiodesc()
    {
        return $this->cantidadesbeneficiodesc;
    }

    /**
     * Set cantidadesbeneficioinstpuntaje
     *
     * @param integer $cantidadesbeneficioinstpuntaje
     *
     * @return Cantidadesbeneficioinst
     */
    public function setCantidadesbeneficioinstpuntaje($cantidadesbeneficioinstpuntaje)
    {
        $this->cantidadesbeneficioinstpuntaje = $cantidadesbeneficioinstpuntaje;

        return $this;
    }

    /**
     * Get cantidadesbeneficioinstpuntaje
     *
     * @return integer
     */
    public function getCantidadesbeneficioinstpuntaje()
    {
        return $this->cantidadesbeneficioinstpuntaje;
    }

    /**
     * Set cantidadesbeneficioinstestado
     *
     * @param boolean $cantidadesbeneficioinstestado
     *
     * @return Cantidadesbeneficioinst
     */
    public function setCantidadesbeneficioinstestado($cantidadesbeneficioinstestado)
    {
        $this->cantidadesbeneficioinstestado = $cantidadesbeneficioinstestado;

        return $this;
    }

    /**
     * Get cantidadesbeneficioinstestado
     *
     * @return boolean
     */
    public function getCantidadesbeneficioinstestado()
    {
        return $this->cantidadesbeneficioinstestado;
    }
}
