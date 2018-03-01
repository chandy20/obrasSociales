<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estadosciviles
 *
 * @ORM\Table(name="estadosciviles")
 * @ORM\Entity
 */
class Estadosciviles
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
     * @ORM\Column(name="EstadoCivilNombre", type="string", length=45, nullable=false)
     */
    private $estadocivilnombre;

    public function __toString(){
    return (string) $this->getEstadocivilnombre();
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
     * Set estadocivilnombre
     *
     * @param string $estadocivilnombre
     *
     * @return Estadosciviles
     */
    public function setEstadocivilnombre($estadocivilnombre)
    {
        $this->estadocivilnombre = $estadocivilnombre;

        return $this;
    }

    /**
     * Get estadocivilnombre
     *
     * @return string
     */
    public function getEstadocivilnombre()
    {
        return $this->estadocivilnombre;
    }

   
}
