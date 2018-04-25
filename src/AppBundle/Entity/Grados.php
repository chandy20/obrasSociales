<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grados
 *
 * @ORM\Table(name="grados")
 * @ORM\Entity
 */
class Grados
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
     * @ORM\Column(name="GradoNombre", type="string", length=45, nullable=false)
     */
    private $gradonombre;

public function __toString(){
    return (string) $this->getgradonombre();
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
     * Set gradonombre
     *
     * @param string $gradonombre
     *
     * @return Grados
     */
    public function setGradonombre($gradonombre)
    {
        $this->gradonombre = $gradonombre;

        return $this;
    }

    /**
     * Get gradonombre
     *
     * @return string
     */
    public function getGradonombre()
    {
        return $this->gradonombre;
    }
    public function getNombre()
    {
        return $this->gradonombre;
    }
}
