<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgramaConcepto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProgramaConceptoRepository")
 */
class ProgramaConcepto {
    
    public function __toString() {
        return $this->getPrograma() ? $this->getPrograma()->getProgramanombre() : "";
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
     * @var boolean
     *
     * @ORM\Column(name="aprobado", type="boolean", nullable=false)
     */
    private $aprobado;

    /**
     * @ORM\ManyToOne(targetEntity="Conceptosjunta", inversedBy="programasConcepto")
     * @ORM\JoinColumn(name="concepto_junta_id", referencedColumnName="id")
     */
    private $conceptoJunta;

    /**
     * @ORM\ManyToOne(targetEntity="Programas", inversedBy="programasConcepto")
     * @ORM\JoinColumn(name="programa_id", referencedColumnName="id")
     */
    private $programa;

    /**
     * @var integer
     *
     * @ORM\Column(name="unidades_aprobadas", type="integer", nullable=true)
     */
    private $unidadesAprobadas;
    
    /**
     * @var float
     *
     * @ORM\Column(name="valor_programa", type="float", nullable=true)
     */
    private $valorPrograma;

   
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
     * Set aprobado
     *
     * @param boolean $aprobado
     *
     * @return ProgramaConcepto
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
     * Set unidadesAprobadas
     *
     * @param integer $unidadesAprobadas
     *
     * @return ProgramaConcepto
     */
    public function setUnidadesAprobadas($unidadesAprobadas)
    {
        $this->unidadesAprobadas = $unidadesAprobadas;

        return $this;
    }

    /**
     * Get unidadesAprobadas
     *
     * @return integer
     */
    public function getUnidadesAprobadas()
    {
        return $this->unidadesAprobadas;
    }

    /**
     * Set conceptoJunta
     *
     * @param \AppBundle\Entity\Conceptosjunta $conceptoJunta
     *
     * @return ProgramaConcepto
     */
    public function setConceptoJunta(\AppBundle\Entity\Conceptosjunta $conceptoJunta = null)
    {
        $this->conceptoJunta = $conceptoJunta;

        return $this;
    }

    /**
     * Get conceptoJunta
     *
     * @return \AppBundle\Entity\Conceptosjunta
     */
    public function getConceptoJunta()
    {
        return $this->conceptoJunta;
    }

    /**
     * Set programa
     *
     * @param \AppBundle\Entity\Programas $programa
     *
     * @return ProgramaConcepto
     */
    public function setPrograma(\AppBundle\Entity\Programas $programa = null)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \AppBundle\Entity\Programas
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set valorPrograma
     *
     * @param float $valorPrograma
     *
     * @return ProgramaConcepto
     */
    public function setValorPrograma($valorPrograma)
    {
        $this->valorPrograma = $valorPrograma;

        return $this;
    }

    /**
     * Get valorPrograma
     *
     * @return float
     */
    public function getValorPrograma()
    {
        return $this->valorPrograma;
    }
}
