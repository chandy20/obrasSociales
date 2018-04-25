<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personascargo
 *
 * @ORM\Table(name="personascargo")
 * @ORM\Entity
 */
class Personascargo {

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
     * @ORM\Column(name="PersonaCargoNombre", type="string", length=45, nullable=false)
     */
    private $personacargonombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="PersonasCargoPuntaje", type="integer", nullable=false)
     */
    private $personascargopuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PersonasCargoEstado", type="boolean", nullable=false)
     */
    private $personascargoestado;

    public function __toString() {
        return (string) $this->getpersonacargonombre();
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
     * Set personacargonombre
     *
     * @param string $personacargonombre
     *
     * @return Personascargo
     */
    public function setPersonacargonombre($personacargonombre) {
        $this->personacargonombre = $personacargonombre;

        return $this;
    }

    /**
     * Get personacargonombre
     *
     * @return string
     */
    public function getPersonacargonombre() {
        return $this->personacargonombre;
    }

    public function getNombre() {
        return $this->personacargonombre;
    }

    /**
     * Set personascargopuntaje
     *
     * @param integer $personascargopuntaje
     *
     * @return Personascargo
     */
    public function setPersonascargopuntaje($personascargopuntaje) {
        $this->personascargopuntaje = $personascargopuntaje;

        return $this;
    }

    /**
     * Get personascargopuntaje
     *
     * @return integer
     */
    public function getPersonascargopuntaje() {
        return $this->personascargopuntaje;
    }

    /**
     * Set personascargoestado
     *
     * @param boolean $personascargoestado
     *
     * @return Personascargo
     */
    public function setPersonascargoestado($personascargoestado) {
        $this->personascargoestado = $personascargoestado;

        return $this;
    }

    /**
     * Get personascargoestado
     *
     * @return boolean
     */
    public function getPersonascargoestado() {
        return $this->personascargoestado;
    }

}
