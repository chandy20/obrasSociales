<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conceptosvisita
 *
 * @ORM\Table(name="conceptosvisita")
 * @ORM\Entity
 */
class Conceptosvisita
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idConceptoVisita", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconceptovisita;

    /**
     * @var string
     *
     * @ORM\Column(name="ConceptoVisitaNombre", type="string", length=100, nullable=false)
     */
    private $conceptovisitanombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="ConceptosVisitaPuntaje", type="integer", nullable=false)
     */
    private $conceptosvisitapuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ConceptosVisitaEstado", type="boolean", nullable=false)
     */
    private $conceptosvisitaestado;

public function __toString(){
    return (string) $this->getconceptovisitanombre();
}

    /**
     * Get idconceptovisita
     *
     * @return integer
     */
    public function getIdconceptovisita()
    {
        return $this->idconceptovisita;
    }

    /**
     * Set conceptovisitanombre
     *
     * @param string $conceptovisitanombre
     *
     * @return Conceptosvisita
     */
    public function setConceptovisitanombre($conceptovisitanombre)
    {
        $this->conceptovisitanombre = $conceptovisitanombre;

        return $this;
    }

    /**
     * Get conceptovisitanombre
     *
     * @return string
     */
    public function getConceptovisitanombre()
    {
        return $this->conceptovisitanombre;
    }

    /**
     * Set conceptosvisitapuntaje
     *
     * @param integer $conceptosvisitapuntaje
     *
     * @return Conceptosvisita
     */
    public function setConceptosvisitapuntaje($conceptosvisitapuntaje)
    {
        $this->conceptosvisitapuntaje = $conceptosvisitapuntaje;

        return $this;
    }

    /**
     * Get conceptosvisitapuntaje
     *
     * @return integer
     */
    public function getConceptosvisitapuntaje()
    {
        return $this->conceptosvisitapuntaje;
    }

    /**
     * Set conceptosvisitaestado
     *
     * @param boolean $conceptosvisitaestado
     *
     * @return Conceptosvisita
     */
    public function setConceptosvisitaestado($conceptosvisitaestado)
    {
        $this->conceptosvisitaestado = $conceptosvisitaestado;

        return $this;
    }

    /**
     * Get conceptosvisitaestado
     *
     * @return boolean
     */
    public function getConceptosvisitaestado()
    {
        return $this->conceptosvisitaestado;
    }
}
