<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Situacionesvivienda
 *
 * @ORM\Table(name="situacionesvivienda")
 * @ORM\Entity
 */
class Situacionesvivienda {

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
     * @ORM\Column(name="SituacionViviendaNombre", type="string", length=100, nullable=false)
     */
    private $situacionviviendanombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="SituacionesViviendaPuntaje", type="integer", nullable=false)
     */
    private $situacionesviviendapuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SituacionesViviendaEstado", type="boolean", nullable=false)
     */
    private $situacionesviviendaestado;

    public function __toString() {
        return (string) $this->getsituacionviviendanombre();
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
     * Set situacionviviendanombre
     *
     * @param string $situacionviviendanombre
     *
     * @return Situacionesvivienda
     */
    public function setSituacionviviendanombre($situacionviviendanombre) {
        $this->situacionviviendanombre = $situacionviviendanombre;

        return $this;
    }

    /**
     * Get situacionviviendanombre
     *
     * @return string
     */
    public function getSituacionviviendanombre() {
        return $this->situacionviviendanombre;
    }

    public function getNombre() {
        return $this->situacionviviendanombre;
    }

    /**
     * Set situacionesviviendapuntaje
     *
     * @param integer $situacionesviviendapuntaje
     *
     * @return Situacionesvivienda
     */
    public function setSituacionesviviendapuntaje($situacionesviviendapuntaje) {
        $this->situacionesviviendapuntaje = $situacionesviviendapuntaje;

        return $this;
    }

    /**
     * Get situacionesviviendapuntaje
     *
     * @return integer
     */
    public function getSituacionesviviendapuntaje() {
        return $this->situacionesviviendapuntaje;
    }

    /**
     * Set situacionesviviendaestado
     *
     * @param boolean $situacionesviviendaestado
     *
     * @return Situacionesvivienda
     */
    public function setSituacionesviviendaestado($situacionesviviendaestado) {
        $this->situacionesviviendaestado = $situacionesviviendaestado;

        return $this;
    }

    /**
     * Get situacionesviviendaestado
     *
     * @return boolean
     */
    public function getSituacionesviviendaestado() {
        return $this->situacionesviviendaestado;
    }

}
