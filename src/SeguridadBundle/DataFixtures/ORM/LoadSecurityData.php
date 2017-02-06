<?php
namespace SeguridadBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use SeguridadBundle\Entity\Role;
use SeguridadBundle\Entity\User;

class LoadSecurityData implements FixtureInterface, ContainerAwareInterface
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
		//generate a new role
		$role = new Role();
		$role->setRole('ROLE_ADMIN');
		$manager->persist($role);
		$manager->flush();

		//generate a new user
		$user = new User();
		$user->setUsername('administrador');
		$encoder        = $this->container->get('security.encoder_factory')->getEncoder($user);
		$password       = $encoder->encodePassword("administrador", $user->getSalt());
		$user->setPassword($password);
		$user->addRole($role);
		$manager->persist($user);
		$manager->flush();

        $role = new Role();
		$role->setRole('ROLE_USER');
		$manager->persist($role);
		$manager->flush();


        $user = new User();
		$user->setUsername('usuario');
		$encoder        = $this->container->get('security.encoder_factory')->getEncoder($user);
		$password       = $encoder->encodePassword("usuario", $user->getSalt());
		$user->setPassword($password);
		$user->addRole($role);
		$manager->persist($user);
		$manager->flush();


    }
}
