<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donador
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DonadorRepository")
 */
class Donador
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=20)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="representanteLegal", type="string", length=100)
     */
    private $representanteLegal;

    /**
     * @var string
     *
     * @ORM\Column(name="cargo", type="string", length=20)
     */
    private $cargo;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefonoContacto1", type="string", length=10)
     */
    private $telefonoContacto1;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefonoContacto2", type="string", length=10)
     */
    private $telefonoContacto2;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var \Seccional
     *
     * @ORM\ManyToOne(targetEntity="Seccionales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seccional_id", referencedColumnName="id")
     * })
     */
    private $seccional;

    /**
     * @var \Ciudad
     *
     * @ORM\ManyToOne(targetEntity="Ciudad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ciudad_id", referencedColumnName="id")
     * })
     */
    private $ciudad;


    /**
     * @return string
     */
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
     * @return Donador
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
     * Set documento
     *
     * @param string $documento
     *
     * @return Donador
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set representanteLegal
     *
     * @param string $representanteLegal
     *
     * @return Donador
     */
    public function setRepresentanteLegal($representanteLegal)
    {
        $this->representanteLegal = $representanteLegal;

        return $this;
    }

    /**
     * Get representanteLegal
     *
     * @return string
     */
    public function getRepresentanteLegal()
    {
        return $this->representanteLegal;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     *
     * @return Donador
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Donador
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefonoContacto1
     *
     * @param integer $telefonoContacto1
     *
     * @return Donador
     */
    public function setTelefonoContacto1($telefonoContacto1)
    {
        $this->telefonoContacto1 = $telefonoContacto1;

        return $this;
    }

    /**
     * Get telefonoContacto1
     *
     * @return integer
     */
    public function getTelefonoContacto1()
    {
        return $this->telefonoContacto1;
    }

    /**
     * Set telefonoContacto2
     *
     * @param integer $telefonoContacto2
     *
     * @return Donador
     */
    public function setTelefonoContacto2($telefonoContacto2)
    {
        $this->telefonoContacto2 = $telefonoContacto2;

        return $this;
    }

    /**
     * Get telefonoContacto2
     *
     * @return integer
     */
    public function getTelefonoContacto2()
    {
        return $this->telefonoContacto2;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Donador
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set seccional
     *
     * @param \AppBundle\Entity\Seccionales $seccional
     *
     * @return Donador
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

    /**
     * Set ciudad
     *
     * @param \AppBundle\Entity\Ciudad $ciudad
     *
     * @return Donador
     */
    public function setCiudad(\AppBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \AppBundle\Entity\Ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }
}
