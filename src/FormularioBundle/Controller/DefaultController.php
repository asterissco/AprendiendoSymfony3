<?php

namespace FormularioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $form = $this->createTestForm();

        return $this->render('FormularioBundle:Default:index.html.twig', array(
            'formulario'    => $form->createView(),
        ));
    }

    public function calculoAction(Request $request){

        $form = $this->createTestForm();
        $form->handleRequest($request);

        echo $form->get('numero1')->getData();

        if(!is_numeric($form->get('numero1')->getData())){
            $form->get('numero1')->addError(new FormError("Debes meter un numero amigo"));
        }


        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();

            $resultado = $data['numero1']+$data['numero2'];

            return $this->redirect($this->generateUrl('formulario_resultado', array(
                'dato' => $resultado,
            )));

        }

        return $this->render('FormularioBundle:Default:index.html.twig', array(
            'formulario'    => $form->createView(),
        ));

    }

    public function resultadoAction(Request $request, $dato){


        return $this->render('FormularioBundle:Default:resultado.html.twig', array(
            'dato'  => $dato
        ));

    }

    private function createTestForm(){

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        return $formFactory->createBuilder(FormType::Class,null,array(
                'action'    =>$this->generateUrl('formulario_calculo'),
                'method'    =>'POST'))
            ->add('numero1',NumberType::class,array(
                'required' => true,
            ))
            ->add('numero2',TextType::class)
            ->getForm();

    }
}
