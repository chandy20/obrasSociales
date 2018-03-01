<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * otorga
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class otorga
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
     * @ORM\Column(name="otorga", type="string", length=25)
     */
    private $otorga;

     public function __toString(){
    return (string) $this->getotorga();
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
     * Set otorga
     *
     * @param string $otorga
     *
     * @return otorga
     */
    public function setOtorga($otorga)
    {
        $this->otorga = $otorga;

        return $this;
    }

    /**
     * Get otorga
     *
     * @return string
     */
    public function getOtorga()
    {
        return $this->otorga;
    }
}
