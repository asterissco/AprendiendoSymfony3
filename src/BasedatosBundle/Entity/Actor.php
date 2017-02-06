<?php

namespace BasedatosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actor
 *
 * @ORM\Table(name="actor")
 * @ORM\Entity(repositoryClass="BasedatosBundle\Repository\ActorRepository")
 */
class Actor
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo = true;

    /**
     * Relacion con peliculas
     * @ORM\ManyToMany(targetEntity="BasedatosBundle\Entity\Pelicula", mappedBy="reparto")
     */
    private $pelicula;

    public function __construct() {
        $this->pelicula = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Actor
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Actor
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return bool
     */
    public function getActivo()
    {
        return $this->activo;
    }


    /**
     * Add pelicula
     *
     * @param \BasedatosBundle\Entity\Pelicula $pelicula
     *
     * @return Actor
     */
    public function addPelicula(\BasedatosBundle\Entity\Pelicula $pelicula)
    {
        $this->pelicula[] = $pelicula;

        return $this;
    }

    /**
     * Remove pelicula
     *
     * @param \BasedatosBundle\Entity\Pelicula $pelicula
     */
    public function removePelicula(\BasedatosBundle\Entity\Pelicula $pelicula)
    {
        $this->pelicula->removeElement($pelicula);
    }

    /**
     * Get pelicula
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPelicula()
    {
        return $this->pelicula;
    }

    public function __toString(){
        return $this->nombre;
    }
}
