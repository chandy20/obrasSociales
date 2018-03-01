<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programas
 *
 * @ORM\Table(name="programas", indexes={@ORM\Index(name="fk_Programas_Areas_idx", columns={"idArea"})})
 * @ORM\Entity
 */
class Programas
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

public function __toString(){
    return (string) $this->getProgramanombre();
}


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
     * Set programanombre
     *
     * @param string $programanombre
     *
     * @return Programas
     */
    public function setProgramanombre($programanombre)
    {
        $this->programanombre = $programanombre;

        return $this;
    }

    /**
     * Get programanombre
     *
     * @return string
     */
    public function getProgramanombre()
    {
        return $this->programanombre;
    }

    /**
     * Set idarea
     *
     * @param \AppBundle\Entity\Areas $idarea
     *
     * @return Programas
     */
    public function setIdarea(\AppBundle\Entity\Areas $idarea = null)
    {
        $this->idarea = $idarea;

        return $this;
    }

    /**
     * Get idarea
     *
     * @return \AppBundle\Entity\Areas
     */
    public function getIdarea()
    {
        return $this->idarea;
    }
}
