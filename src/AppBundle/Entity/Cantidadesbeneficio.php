<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cantidadesbeneficio
 *
 * @ORM\Table(name="cantidadesbeneficio")
 * @ORM\Entity
 */
class Cantidadesbeneficio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cantidadesbeneficio_id;

    /**
     * @var string
     *
     * @ORM\Column(name="CantidadBeneficioNombre", type="string", length=100, nullable=false)
     */
    private $cantidadbeneficionombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="CantidadBeneficioPuntaje", type="integer", nullable=false)
     */
    private $cantidadbeneficiopuntaje;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CantidadesBeneficioEstado", type="boolean", nullable=false)
     */
    private $cantidadesbeneficioestado;

    public function __toString(){
        return (string) $this->getCantidadbeneficionombre();
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
     * Set cantidadbeneficionombre
     *
     * @param string $cantidadbeneficionombre
     *
     * @return Cantidadesbeneficio
     */
    public function setCantidadbeneficionombre($cantidadbeneficionombre)
    {
        $this->cantidadbeneficionombre = $cantidadbeneficionombre;

        return $this;
    }

    /**
     * Get cantidadbeneficionombre
     *
     * @return string
     */
    public function getCantidadbeneficionombre()
    {
        return $this->cantidadbeneficionombre;
    }

    /**
     * Set cantidadbeneficiopuntaje
     *
     * @param integer $cantidadbeneficiopuntaje
     *
     * @return Cantidadesbeneficio
     */
    public function setCantidadbeneficiopuntaje($cantidadbeneficiopuntaje)
    {
        $this->cantidadbeneficiopuntaje = $cantidadbeneficiopuntaje;

        return $this;
    }

    /**
     * Get cantidadbeneficiopuntaje
     *
     * @return integer
     */
    public function getCantidadbeneficiopuntaje()
    {
        return $this->cantidadbeneficiopuntaje;
    }

    /**
     * Set cantidadesbeneficioestado
     *
     * @param boolean $cantidadesbeneficioestado
     *
     * @return Cantidadesbeneficio
     */
    public function setCantidadesbeneficioestado($cantidadesbeneficioestado)
    {
        $this->cantidadesbeneficioestado = $cantidadesbeneficioestado;

        return $this;
    }

    /**
     * Get cantidadesbeneficioestado
     *
     * @return boolean
     */
    public function getCantidadesbeneficioestado()
    {
        return $this->cantidadesbeneficioestado;
    }

    /**
     * Get cantidadesbeneficioId
     *
     * @return integer
     */
    public function getCantidadesbeneficioId()
    {
        return $this->cantidadesbeneficio_id;
    }
}
