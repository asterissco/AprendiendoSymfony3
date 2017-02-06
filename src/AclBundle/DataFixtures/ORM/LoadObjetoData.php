<?php
namespace SeguridadBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AclBundle\Entity\Objeto;


class LoadObjetoData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        //genero varios opbjetos
		$objeto = new Objeto();
		$objeto->setNombre('Lapiz Azúl');
		$manager->persist($objeto);
		$manager->flush();

        $objeto = new Objeto();
		$objeto->setNombre('Coche rojo');
		$manager->persist($objeto);
		$manager->flush();

        $objeto = new Objeto();
		$objeto->setNombre('Bicicleta antigua');
		$manager->persist($objeto);
		$manager->flush();

        $objeto = new Objeto();
		$objeto->setNombre('Teléfono');
		$manager->persist($objeto);
		$manager->flush();

    }
}
