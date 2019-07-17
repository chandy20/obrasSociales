<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CiudadRepository")
 */
class Ciudad
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=20)
     */
    private $nombre;

    /**
     * @var \Seccional
     *
     * @ORM\ManyToOne(targetEntity="Seccionales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seccional_id", referencedColumnName="id")
     * })
     */
    private $seccional;

    public function __toString()
    {
       return $this->getNombre() ? $this->getNombre() : "";
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Ciudad
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set seccional
     *
     * @param \AppBundle\Entity\Seccionales $seccional
     *
     * @return Ciudad
     */
    public function setSeccional(\AppBundle\Entity\Seccionales $seccional = null)
    {
        $this->seccional = $seccional;

        return $this;
    }

    /**
     * Get seccional
     *
     * @return \AppBundle\Entity\Seccionales
     */
    public function getSeccional()
    {
        return $this->seccional;
    }
}
