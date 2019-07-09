<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DonacionRepository")
 */
class Donacion
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
     * @var integer
     *
     * @ORM\Column(name="monto", type="integer")
     */
    private $monto;

    /**
     * @var \Donador
     *
     * @ORM\ManyToOne(targetEntity="Donador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="donador_id", referencedColumnName="id")
     * })
     */
    private $donador;

    /**
     * @var \Evento
     *
     * @ORM\ManyToOne(targetEntity="Evento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evento_id", referencedColumnName="id")
     * })
     */
    private $evento;


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
     * Set monto
     *
     * @param integer $monto
     *
     * @return Donacion
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return integer
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set donador
     *
     * @param \AppBundle\Entity\Donador $donador
     *
     * @return Donacion
     */
    public function setDonador(\AppBundle\Entity\Donador $donador = null)
    {
        $this->donador = $donador;

        return $this;
    }

    /**
     * Get donador
     *
     * @return \AppBundle\Entity\Donador
     */
    public function getDonador()
    {
        return $this->donador;
    }

    /**
     * Set evento
     *
     * @param \AppBundle\Entity\Evento $evento
     *
     * @return Donacion
     */
    public function setEvento(\AppBundle\Entity\Evento $evento = null)
    {
        $this->evento = $evento;

        return $this;
    }

    /**
     * Get evento
     *
     * @return \AppBundle\Entity\Evento
     */
    public function getEvento()
    {
        return $this->evento;
    }
}
