<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgramaSolicitud
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProgramaSolicitudRepository")
 */
class ProgramaSolicitud {

    function __construct($programa, $solicitud) {
        $this->programa = $programa;
        $this->solicitud = $solicitud;
    }
    
    public function __toString() {
        return "";
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Programas", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="programa_id", referencedColumnName="id")
     */
    private $programa;

    /**
     * @ORM\ManyToOne(targetEntity="Solicitudes", inversedBy="programas")
     * @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     */
    private $solicitud;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set programa
     *
     * @param \AppBundle\Entity\Programas $programa
     *
     * @return ProgramaSolicitud
     */
    public function setPrograma(\AppBundle\Entity\Programas $programa = null) {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \AppBundle\Entity\Programas
     */
    public function getPrograma() {
        return $this->programa;
    }

    /**
     * Set solicitud
     *
     * @param \AppBundle\Entity\Solicitudes $solicitud
     *
     * @return ProgramaSolicitud
     */
    public function setSolicitud(\AppBundle\Entity\Solicitudes $solicitud = null) {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \AppBundle\Entity\Solicitudes
     */
    public function getSolicitud() {
        return $this->solicitud;
    }

}
