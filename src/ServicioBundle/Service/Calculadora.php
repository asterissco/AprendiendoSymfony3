<?php

namespace ServicioBundle\Service;

class Calculadora{

    private $entityName;
    private $em;

    // en el constructor se injectan dependencias
    public function __construct(
        \Doctrine\ORM\EntityManager $entityManager
    ){

        $this->em = $entityManager;

    }

    /* no se puede usar el constructo para iniciar parametros en el objeto */
    public function init(string $entityName){

        $this->entityName = $entityName;

    }

    public function getNumRow(){

        return count($this->em->getRepository($this->entityName)->findAll());

    }


}
