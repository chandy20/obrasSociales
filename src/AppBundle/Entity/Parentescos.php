<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parentescos
 *
 * @ORM\Table(name="parentescos")
 * @ORM\Entity
 */
class Parentescos {

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
     * @ORM\Column(name="ParentescoNombre", type="string", length=45, nullable=true)
     */
    private $parentesconombre;

    public function __toString() {
        return (string) $this->getParentesconombre();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set parentesconombre
     *
     * @param string $parentesconombre
     *
     * @return Parentescos
     */
    public function setParentesconombre($parentesconombre) {
        $this->parentesconombre = $parentesconombre;

        return $this;
    }

    /**
     * Get parentesconombre
     *
     * @return string
     */
    public function getParentesconombre() {
        return $this->parentesconombre;
    }
    public function getNombre() {
        return $this->parentesconombre;
    }

}
