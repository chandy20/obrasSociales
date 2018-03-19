<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zonasubicacion
 *
 * @ORM\Table(name="zonasubicacion")
 * @ORM\Entity
 */
class Zonasubicacion {

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
     * @ORM\Column(name="ZonasUbicacionNombre", type="string", length=100, nullable=false)
     */
    private $zonasubicacionnombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="ZonasUbicacionPuntaje", type="integer", nullable=false)
     */
    private $zonasubicacionpuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ZonasUbicacionEstado", type="boolean", nullable=false)
     */
    private $zonasubicacionestado;

    public function __toString() {
        return (string) $this->getzonasubicacionnombre();
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
     * Set zonasubicacionnombre
     *
     * @param string $zonasubicacionnombre
     *
     * @return Zonasubicacion
     */
    public function setZonasubicacionnombre($zonasubicacionnombre) {
        $this->zonasubicacionnombre = $zonasubicacionnombre;

        return $this;
    }

    /**
     * Get zonasubicacionnombre
     *
     * @return string
     */
    public function getZonasubicacionnombre() {
        return $this->zonasubicacionnombre;
    }

    /**
     * Set zonasubicacionpuntaje
     *
     * @param integer $zonasubicacionpuntaje
     *
     * @return Zonasubicacion
     */
    public function setZonasubicacionpuntaje($zonasubicacionpuntaje) {
        $this->zonasubicacionpuntaje = $zonasubicacionpuntaje;

        return $this;
    }

    /**
     * Get zonasubicacionpuntaje
     *
     * @return integer
     */
    public function getZonasubicacionpuntaje() {
        return $this->zonasubicacionpuntaje;
    }

    /**
     * Set zonasubicacionestado
     *
     * @param boolean $zonasubicacionestado
     *
     * @return Zonasubicacion
     */
    public function setZonasubicacionestado($zonasubicacionestado) {
        $this->zonasubicacionestado = $zonasubicacionestado;

        return $this;
    }

    /**
     * Get zonasubicacionestado
     *
     * @return boolean
     */
    public function getZonasubicacionestado() {
        return $this->zonasubicacionestado;
    }

}
