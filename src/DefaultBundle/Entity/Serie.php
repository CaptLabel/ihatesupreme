<?php

namespace DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Serie
 *
 * @ORM\Table(name="serie")
 * @ORM\Entity(repositoryClass="DefaultBundle\Repository\SerieRepository")
 */
class Serie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToOne(targetEntity="DefaultBundle\Entity\Edito", cascade={"persist", "remove"})
     */
    private $edito;

    /**
     * @ORM\ManyToMany(targetEntity="DefaultBundle\Entity\Going", cascade={"persist", "remove"})
     */
    private $goings;

    /**
     * @return mixed
     */
    public function getEdito()
    {
        return $this->edito;
    }

    /**
     * @param mixed $edito
     */
    public function setEdito($edito)
    {
        $this->edito = $edito;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Serie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->goings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add going
     *
     * @param \DefaultBundle\Entity\Going $going
     *
     * @return Serie
     */
    public function addGoing(\DefaultBundle\Entity\Going $going)
    {
        $this->goings[] = $going;

        return $this;
    }

    /**
     * Remove going
     *
     * @param \DefaultBundle\Entity\Going $going
     */
    public function removeGoing(\DefaultBundle\Entity\Going $going)
    {
        $this->goings->removeElement($going);
    }

    /**
     * Get goings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoings()
    {
        return $this->goings;
    }
}
