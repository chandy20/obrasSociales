<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programas
 *
 * @ORM\Table(name="programas", indexes={@ORM\Index(name="fk_Programas_Areas_idx", columns={"idArea"})})
 * @ORM\Entity
 */
class Programas {

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
     * @ORM\Column(name="ProgramaNombre", type="string", length=150, nullable=false)
     */
    private $programanombre;

    /**
     * @var \Areas
     *
     * @ORM\ManyToOne(targetEntity="Areas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArea", referencedColumnName="id")
     * })
     */
    private $idarea;

    /**
     * @ORM\OneToMany(targetEntity="ProgramaSolicitud", mappedBy="programa" , cascade={"persist"})
     */
    private $solicitudes;

    public function __toString() {
        return (string) $this->getProgramanombre();
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
     * Set programanombre
     *
     * @param string $programanombre
     *
     * @return Programas
     */
    public function setProgramanombre($programanombre) {
        $this->programanombre = $programanombre;

        return $this;
    }

    /**
     * Get programanombre
     *
     * @return string
     */
    public function getProgramanombre() {
        return $this->programanombre;
    }

    /**
     * Set idarea
     *
     * @param \AppBundle\Entity\Areas $idarea
     *
     * @return Programas
     */
    public function setIdarea(\AppBundle\Entity\Areas $idarea = null) {
        $this->idarea = $idarea;

        return $this;
    }

    /**
     * Get idarea
     *
     * @return \AppBundle\Entity\Areas
     */
    public function getIdarea() {
        return $this->idarea;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add solicitude
     *
     * @param \AppBundle\Entity\ProgramaSolicitud $solicitude
     *
     * @return Programas
     */
    public function addSolicitude(\AppBundle\Entity\ProgramaSolicitud $solicitude)
    {
        $this->solicitudes[] = $solicitude;

        return $this;
    }

    /**
     * Remove solicitude
     *
     * @param \AppBundle\Entity\ProgramaSolicitud $solicitude
     */
    public function removeSolicitude(\AppBundle\Entity\ProgramaSolicitud $solicitude)
    {
        $this->solicitudes->removeElement($solicitude);
    }

    /**
     * Get solicitudes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }
}
