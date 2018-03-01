<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Areas
 *
 * @ORM\Table(name="areas")
 * @ORM\Entity
 */
class Areas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArea;

    /**
     * @var string
     *
     * @ORM\Column(name="AreaNombre", type="string", length=100, nullable=false)
     */
    private $areanombre;

public function __toString(){
    return (string) $this->getareanombre();
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
     * Set areanombre
     *
     * @param string $areanombre
     *
     * @return Areas
     */
    public function setAreanombre($areanombre)
    {
        $this->areanombre = $areanombre;

        return $this;
    }

    /**
     * Get areanombre
     *
     * @return string
     */
    public function getAreanombre()
    {
        return $this->areanombre;
    }

    /**
     * Get idArea
     *
     * @return integer
     */
    public function getIdArea()
    {
        return $this->idArea;
    }
}
