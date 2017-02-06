<?php

namespace BasedatosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use BasedatosBundle\Validator\Constraints as MiValidator;

/**
 * Pelicula
 *
 * @ORM\Table(name="pelicula")
 * @ORM\Entity(repositoryClass="BasedatosBundle\Repository\PeliculaRepository")
 * @UniqueEntity("nombre")
 */
class Pelicula
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
     * @MiValidator\MiCriterio
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anio", type="date")
     */
    private $anio;

    /**
     * Relacion con actores
     * @ORM\ManyToMany(targetEntity="BasedatosBundle\Entity\Actor", inversedBy="pelicula")
     * @ORM\JoinTable(name="pelicula_actor")
     */
    private $reparto;

    public function __construct(){
        $this->reparto =  new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pelicula
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
     * Set anio
     *
     * @param \DateTime $anio
     *
     * @return Pelicula
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return \DateTime
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Add reparto
     *
     * @param \BasedatosBundle\Entity\Actor $reparto
     *
     * @return Pelicula
     */
    public function addReparto(\BasedatosBundle\Entity\Actor $reparto)
    {
        $this->reparto[] = $reparto;

        return $this;
    }

    /**
     * Remove reparto
     *
     * @param \BasedatosBundle\Entity\Actor $reparto
     */
    public function removeReparto(\BasedatosBundle\Entity\Actor $reparto)
    {
        $this->reparto->removeElement($reparto);
    }

    /**
     * Get reparto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReparto()
    {
        return $this->reparto;
    }

    public function __toString(){
        return $this->nombre;
    }
}
