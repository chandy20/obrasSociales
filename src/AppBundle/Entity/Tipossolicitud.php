<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipossolicitud
 *
 * @ORM\Table(name="tipossolicitud")
 * @ORM\Entity
 */
class Tipossolicitud {

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
     * @ORM\Column(name="TipoSolicitudNombre", type="string", length=100, nullable=false)
     */
    private $tiposolicitudnombre;

    public function __toString() {
        return (string) $this->getTiposolicitudnombre();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set tiposolicitudnombre
     *
     * @param string $tiposolicitudnombre
     *
     * @return Tipossolicitud
     */
    public function setTiposolicitudnombre($tiposolicitudnombre) {
        $this->tiposolicitudnombre = $tiposolicitudnombre;

        return $this;
    }

    /**
     * Get tiposolicitudnombre
     *
     * @return string
     */
    public function getTiposolicitudnombre() {
        return $this->tiposolicitudnombre;
    }

    public function getNombre() {
        return $this->tiposolicitudnombre;
    }

}
