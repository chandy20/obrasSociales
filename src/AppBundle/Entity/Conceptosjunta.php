<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptosjunta
 *
 * @ORM\Table(name="conceptosjunta", indexes={@ORM\Index(name="fk_ConceptosJunta_Solicitudes1_idx", columns={"solicitud_id"})})
 * @ORM\Entity
 */
class Conceptosjunta {
    
    public function __toString() {
        return "";
    }

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
     * @ORM\Column(name="ConceptoJuntaValorB", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $conceptojuntavalorb;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptoJuntaValorTotalB", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $conceptojuntavalortotalb;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptosJuntaDesc", type="string", length=3000, nullable=true)
     */
    private $conceptosjuntadesc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ConceptosJuntaOtorgada", type="boolean", nullable=true)
     */
    private $conceptosjuntaotorgada;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptosJuntaNumActa", type="string", length=45, nullable=true)
     */
    private $conceptosjuntanumacta;

    /**
     * @var \Solicitudes
     *
     * @ORM\ManyToOne(targetEntity="Solicitudes", inversedBy="conceptoJunta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     * })
     */
    private $solicitud;

    /**
     * @ORM\OneToMany(targetEntity="ProgramaConcepto", mappedBy="conceptoJunta" , cascade={"persist"})
     */
    private $programasConcepto;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="aprobado", type="boolean", nullable=true)
     */
    private $aprobado;
    
     /**
     * @var boolean
     *
     * @ORM\Column(name="editado", type="boolean", nullable=true)
     */
    private $editado;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set conceptojuntavalorb
     *
     * @param string $conceptojuntavalorb
     *
     * @return Conceptosjunta
     */
    public function setConceptojuntavalorb($conceptojuntavalorb) {
        $this->conceptojuntavalorb = $conceptojuntavalorb;

        return $this;
    }

    /**
     * Get conceptojuntavalorb
     *
     * @return string
     */
    public function getConceptojuntavalorb() {
        return $this->conceptojuntavalorb;
    }

    /**
     * Set conceptojuntavalortotalb
     *
     * @param string $conceptojuntavalortotalb
     *
     * @return Conceptosjunta
     */
    public function setConceptojuntavalortotalb($conceptojuntavalortotalb) {
        $this->conceptojuntavalortotalb = $conceptojuntavalortotalb;

        return $this;
    }

    /**
     * Get conceptojuntavalortotalb
     *
     * @return string
     */
    public function getConceptojuntavalortotalb() {
        return $this->conceptojuntavalortotalb;
    }

    /**
     * Set conceptosjuntadesc
     *
     * @param string $conceptosjuntadesc
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntadesc($conceptosjuntadesc) {
        $this->conceptosjuntadesc = $conceptosjuntadesc;

        return $this;
    }

    /**
     * Get conceptosjuntadesc
     *
     * @return string
     */
    public function getConceptosjuntadesc() {
        return $this->conceptosjuntadesc;
    }

    /**
     * Set conceptosjuntaotorgada
     *
     * @param boolean $conceptosjuntaotorgada
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntaotorgada($conceptosjuntaotorgada) {
        $this->conceptosjuntaotorgada = $conceptosjuntaotorgada;

        return $this;
    }

    /**
     * Get conceptosjuntaotorgada
     *
     * @return boolean
     */
    public function getConceptosjuntaotorgada() {
        return $this->conceptosjuntaotorgada;
    }

    /**
     * Set conceptosjuntanumacta
     *
     * @param string $conceptosjuntanumacta
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntanumacta($conceptosjuntanumacta) {
        $this->conceptosjuntanumacta = $conceptosjuntanumacta;

        return $this;
    }

    /**
     * Get conceptosjuntanumacta
     *
     * @return string
     */
    public function getConceptosjuntanumacta() {
        return $this->conceptosjuntanumacta;
    }

    /**
     * Set solicitud
     *
     * @param \AppBundle\Entity\Solicitudes $solicitud
     *
     * @return Conceptosjunta
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

    /**
     * Constructor
     */
    public function __construct() {
        $this->programasConcepto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add programasConcepto
     *
     * @param \AppBundle\Entity\ProgramaConcepto $programasConcepto
     *
     * @return Conceptosjunta
     */
    public function addProgramasConcepto(\AppBundle\Entity\ProgramaConcepto $programasConcepto) {
        $this->programasConcepto[] = $programasConcepto;

        return $this;
    }

    /**
     * Remove programasConcepto
     *
     * @param \AppBundle\Entity\ProgramaConcepto $programasConcepto
     */
    public function removeProgramasConcepto(\AppBundle\Entity\ProgramaConcepto $programasConcepto) {
        $this->programasConcepto->removeElement($programasConcepto);
    }

    /**
     * Get programasConcepto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgramasConcepto() {
        return $this->programasConcepto;
    }


    /**
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return Conceptosjunta
     */
    public function setAprobado($aprobado)
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * Get aprobado
     *
     * @return boolean
     */
    public function getAprobado()
    {
        return $this->aprobado;
    }

    /**
     * Set editado
     *
     * @param boolean $editado
     *
     * @return Conceptosjunta
     */
    public function setEditado($editado)
    {
        $this->editado = $editado;

        return $this;
    }

    /**
     * Get editado
     *
     * @return boolean
     */
    public function getEditado()
    {
        return $this->editado;
    }
}
