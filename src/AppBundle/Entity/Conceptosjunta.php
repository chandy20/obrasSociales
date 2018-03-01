<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptosjunta
 *
 * @ORM\Table(name="conceptosjunta", indexes={@ORM\Index(name="fk_ConceptosJunta_Solicitudes1_idx", columns={"solicitud_id"})})
 * @ORM\Entity
 */
class Conceptosjunta
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
     * @ORM\Column(name="ConceptoJuntaValorB", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $conceptojuntavalorb;

    /**
     * @var integer
     *
     * @ORM\Column(name="ConceptoJuntaTiempo", type="integer", nullable=false)
     */
    private $conceptojuntatiempo;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptoJuntaValorTotalB", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $conceptojuntavalortotalb;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptosJuntaDesc", type="string", length=3000, nullable=false)
     */
    private $conceptosjuntadesc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ConceptosJuntaOtorgada", type="boolean", nullable=false)
     */
    private $conceptosjuntaotorgada;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptosJuntaNumActa", type="string", length=45, nullable=false)
     */
    private $conceptosjuntanumacta;

    /**
     * @var \Solicitudes
     *
     * @ORM\ManyToOne(targetEntity="Solicitudes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="solicitud_id", referencedColumnName="id")
     * })
     */
    private $solicitud;



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
     * Set conceptojuntavalorb
     *
     * @param string $conceptojuntavalorb
     *
     * @return Conceptosjunta
     */
    public function setConceptojuntavalorb($conceptojuntavalorb)
    {
        $this->conceptojuntavalorb = $conceptojuntavalorb;

        return $this;
    }

    /**
     * Get conceptojuntavalorb
     *
     * @return string
     */
    public function getConceptojuntavalorb()
    {
        return $this->conceptojuntavalorb;
    }

    /**
     * Set conceptojuntatiempo
     *
     * @param integer $conceptojuntatiempo
     *
     * @return Conceptosjunta
     */
    public function setConceptojuntatiempo($conceptojuntatiempo)
    {
        $this->conceptojuntatiempo = $conceptojuntatiempo;

        return $this;
    }

    /**
     * Get conceptojuntatiempo
     *
     * @return integer
     */
    public function getConceptojuntatiempo()
    {
        return $this->conceptojuntatiempo;
    }

    /**
     * Set conceptojuntavalortotalb
     *
     * @param string $conceptojuntavalortotalb
     *
     * @return Conceptosjunta
     */
    public function setConceptojuntavalortotalb($conceptojuntavalortotalb)
    {
        $this->conceptojuntavalortotalb = $conceptojuntavalortotalb;

        return $this;
    }

    /**
     * Get conceptojuntavalortotalb
     *
     * @return string
     */
    public function getConceptojuntavalortotalb()
    {
        return $this->conceptojuntavalortotalb;
    }

    /**
     * Set conceptosjuntadesc
     *
     * @param string $conceptosjuntadesc
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntadesc($conceptosjuntadesc)
    {
        $this->conceptosjuntadesc = $conceptosjuntadesc;

        return $this;
    }

    /**
     * Get conceptosjuntadesc
     *
     * @return string
     */
    public function getConceptosjuntadesc()
    {
        return $this->conceptosjuntadesc;
    }

    /**
     * Set conceptosjuntaotorgada
     *
     * @param boolean $conceptosjuntaotorgada
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntaotorgada($conceptosjuntaotorgada)
    {
        $this->conceptosjuntaotorgada = $conceptosjuntaotorgada;

        return $this;
    }

    /**
     * Get conceptosjuntaotorgada
     *
     * @return boolean
     */
    public function getConceptosjuntaotorgada()
    {
        return $this->conceptosjuntaotorgada;
    }

    /**
     * Set conceptosjuntanumacta
     *
     * @param string $conceptosjuntanumacta
     *
     * @return Conceptosjunta
     */
    public function setConceptosjuntanumacta($conceptosjuntanumacta)
    {
        $this->conceptosjuntanumacta = $conceptosjuntanumacta;

        return $this;
    }

    /**
     * Get conceptosjuntanumacta
     *
     * @return string
     */
    public function getConceptosjuntanumacta()
    {
        return $this->conceptosjuntanumacta;
    }

    /**
     * Set solicitud
     *
     * @param \AppBundle\Entity\Solicitudes $solicitud
     *
     * @return Conceptosjunta
     */
    public function setSolicitud(\AppBundle\Entity\Solicitudes $solicitud = null)
    {
        $this->solicitud = $solicitud;

        return $this;
    }

    /**
     * Get solicitud
     *
     * @return \AppBundle\Entity\Solicitudes
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }
}
