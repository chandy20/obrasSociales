<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Afiliadodibie
 *
 * @ORM\Table(name="afiliadodibie")
 * @ORM\Entity
 */
class Afiliadodibie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idAfiliadoDibie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idafiliadodibie;

    /**
     * @var string
     *
     * @ORM\Column(name="AfiliadoDibieDesc", type="string", length=5, nullable=false)
     */
    private $afiliadodibiedesc;

    /**
     * @var integer
     *
     * @ORM\Column(name="AfiliadoDibiePorcentaje", type="integer", nullable=false)
     */
    private $afiliadodibieporcentaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="AfiliadoDibieEstado", type="boolean", nullable=false)
     */
    private $afiliadodibieestado;

public function __toString(){
    return (string) $this->getafiliadodibiedesc();
}

    /**
     * Get idafiliadodibie
     *
     * @return integer
     */
    public function getIdafiliadodibie()
    {
        return $this->idafiliadodibie;
    }

    /**
     * Set afiliadodibiedesc
     *
     * @param string $afiliadodibiedesc
     *
     * @return Afiliadodibie
     */
    public function setAfiliadodibiedesc($afiliadodibiedesc)
    {
        $this->afiliadodibiedesc = $afiliadodibiedesc;

        return $this;
    }

    /**
     * Get afiliadodibiedesc
     *
     * @return string
     */
    public function getAfiliadodibiedesc()
    {
        return $this->afiliadodibiedesc;
    }

    /**
     * Set afiliadodibieporcentaje
     *
     * @param integer $afiliadodibieporcentaje
     *
     * @return Afiliadodibie
     */
    public function setAfiliadodibieporcentaje($afiliadodibieporcentaje)
    {
        $this->afiliadodibieporcentaje = $afiliadodibieporcentaje;

        return $this;
    }

    /**
     * Get afiliadodibieporcentaje
     *
     * @return integer
     */
    public function getAfiliadodibieporcentaje()
    {
        return $this->afiliadodibieporcentaje;
    }

    /**
     * Set afiliadodibieestado
     *
     * @param boolean $afiliadodibieestado
     *
     * @return Afiliadodibie
     */
    public function setAfiliadodibieestado($afiliadodibieestado)
    {
        $this->afiliadodibieestado = $afiliadodibieestado;

        return $this;
    }

    /**
     * Get afiliadodibieestado
     *
     * @return boolean
     */
    public function getAfiliadodibieestado()
    {
        return $this->afiliadodibieestado;
    }
}
