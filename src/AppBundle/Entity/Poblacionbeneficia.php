<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poblacionbeneficia
 *
 * @ORM\Table(name="poblacionbeneficia")
 * @ORM\Entity
 */
class Poblacionbeneficia
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
     * @ORM\Column(name="PoblacionBeneficiaDesc", type="string", length=100, nullable=false)
     */
    private $poblacionbeneficiadesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="PoblacionBeneficiaPuntaje", type="integer", nullable=false)
     */
    private $poblacionbeneficiapuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PoblacionBeneficiaEstado", type="boolean", nullable=false)
     */
    private $poblacionbeneficiaestado;

public function __toString(){
    return (string) $this->getpoblacionbeneficiadesc();
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
     * Set poblacionbeneficiadesc
     *
     * @param string $poblacionbeneficiadesc
     *
     * @return Poblacionbeneficia
     */
    public function setPoblacionbeneficiadesc($poblacionbeneficiadesc)
    {
        $this->poblacionbeneficiadesc = $poblacionbeneficiadesc;

        return $this;
    }

    /**
     * Get poblacionbeneficiadesc
     *
     * @return string
     */
    public function getPoblacionbeneficiadesc()
    {
        return $this->poblacionbeneficiadesc;
    }

    /**
     * Set poblacionbeneficiapuntaje
     *
     * @param integer $poblacionbeneficiapuntaje
     *
     * @return Poblacionbeneficia
     */
    public function setPoblacionbeneficiapuntaje($poblacionbeneficiapuntaje)
    {
        $this->poblacionbeneficiapuntaje = $poblacionbeneficiapuntaje;

        return $this;
    }

    /**
     * Get poblacionbeneficiapuntaje
     *
     * @return integer
     */
    public function getPoblacionbeneficiapuntaje()
    {
        return $this->poblacionbeneficiapuntaje;
    }

    /**
     * Set poblacionbeneficiaestado
     *
     * @param boolean $poblacionbeneficiaestado
     *
     * @return Poblacionbeneficia
     */
    public function setPoblacionbeneficiaestado($poblacionbeneficiaestado)
    {
        $this->poblacionbeneficiaestado = $poblacionbeneficiaestado;

        return $this;
    }

    /**
     * Get poblacionbeneficiaestado
     *
     * @return boolean
     */
    public function getPoblacionbeneficiaestado()
    {
        return $this->poblacionbeneficiaestado;
    }
}
