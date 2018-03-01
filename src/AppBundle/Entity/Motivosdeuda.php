<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Motivosdeuda
 *
 * @ORM\Table(name="motivosdeuda")
 * @ORM\Entity
 */
class Motivosdeuda
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
     * @ORM\Column(name="MotivoDeudaNombre", type="string", length=100, nullable=false)
     */
    private $motivodeudanombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="MotivoDeudaPuntaje", type="integer", nullable=false)
     */
    private $motivodeudapuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MotivoDeudaEstado", type="boolean", nullable=false)
     */
    private $motivodeudaestado;

public function __toString(){
    return (string) $this->getmotivodeudanombre();
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
     * Set motivodeudanombre
     *
     * @param string $motivodeudanombre
     *
     * @return Motivosdeuda
     */
    public function setMotivodeudanombre($motivodeudanombre)
    {
        $this->motivodeudanombre = $motivodeudanombre;

        return $this;
    }

    /**
     * Get motivodeudanombre
     *
     * @return string
     */
    public function getMotivodeudanombre()
    {
        return $this->motivodeudanombre;
    }

    /**
     * Set motivodeudapuntaje
     *
     * @param integer $motivodeudapuntaje
     *
     * @return Motivosdeuda
     */
    public function setMotivodeudapuntaje($motivodeudapuntaje)
    {
        $this->motivodeudapuntaje = $motivodeudapuntaje;

        return $this;
    }

    /**
     * Get motivodeudapuntaje
     *
     * @return integer
     */
    public function getMotivodeudapuntaje()
    {
        return $this->motivodeudapuntaje;
    }

    /**
     * Set motivodeudaestado
     *
     * @param boolean $motivodeudaestado
     *
     * @return Motivosdeuda
     */
    public function setMotivodeudaestado($motivodeudaestado)
    {
        $this->motivodeudaestado = $motivodeudaestado;

        return $this;
    }

    /**
     * Get motivodeudaestado
     *
     * @return boolean
     */
    public function getMotivodeudaestado()
    {
        return $this->motivodeudaestado;
    }
}
