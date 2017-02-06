<?php

namespace ServicioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $formulario = $this->formulario();
        $formulario->handleRequest($request);
        $nfila      = 0;
        $entity     = 'ninguno';

        if($formulario->isSubmitted() && $formulario->isValid()){

            //la idea es una calculadura para calcular cosas de un entity, como
            //el numero de filas que tiene
            $calculadora    = $this->get('app.calculadora');
            $entity         = $formulario->getData()['clase'];
            $calculadora->init($entity);

            $nfila = $calculadora->getNumRow();

        }

        return $this->render('ServicioBundle:Default:index.html.twig',array(
            'nfila'         => $nfila,
            'entity'        => $entity,
            'formulario'    => $formulario->createView(),
        ));

    }

    private function formulario(){

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        return $formFactory->createBuilder(FormType::Class,null,array(
            'action'    =>$this->generateUrl('servicio_homepage'),
            'method'    =>'POST'))
            ->add('clase',ChoiceType::class,array(
                'required'          => true,
                'choices'           => array(
                    'AclBundle:Objeto'      => 'AclBundle:Objeto',
                    'SeguridadBundle:User'  => 'SeguridadBundle:User',
                    'SeguridadBundle:Role'  => 'SeguridadBundle:Role',
                ),
            ))
            ->getForm();

    }

}
