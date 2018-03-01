<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seccionales
 *
 * @ORM\Table(name="seccionales")
 * @ORM\Entity
 */
class Seccionales
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
     * @ORM\Column(name="SeccionalNombre", type="string", length=100, nullable=false)
     */
    private $seccionalnombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="SeccionalPresupuesto", type="integer", length=100, nullable=false)
     */
    private $SeccionalPresupuesto;


public function __toString(){
    return (string) $this->getseccionalnombre();
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
     * Set seccionalnombre
     *
     * @param string $seccionalnombre
     *
     * @return Seccionales
     */
    public function setSeccionalnombre($seccionalnombre)
    {
        $this->seccionalnombre = $seccionalnombre;

        return $this;
    }

    /**
     * Get seccionalnombre
     *
     * @return string
     */
    public function getSeccionalnombre()
    {
        return $this->seccionalnombre;
    }

    /**
     * Set seccionalPresupuesto
     *
     * @param integer $seccionalPresupuesto
     *
     * @return Seccionales
     */
    public function setSeccionalPresupuesto($seccionalPresupuesto)
    {
        $this->SeccionalPresupuesto = $seccionalPresupuesto;

        return $this;
    }

    /**
     * Get seccionalPresupuesto
     *
     * @return integer
     */
    public function getSeccionalPresupuesto()
    {
        return $this->SeccionalPresupuesto;
    }
}
