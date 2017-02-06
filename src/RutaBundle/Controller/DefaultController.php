<?php

namespace RutaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('RutaBundle:Default:index.html.twig');
    }

    public function calculadoraEntradaAction(){

        return $this->render('RutaBundle:calculadora:entrada.html.twig');
    }

    public function calculadoraSalidaAction(Request $request, $accion){

        //los cojo todos
        $arrParam=$request->request->all();
        $total = $arrParam['numero1']+$arrParam['numero2'];

        return $this->render('RutaBundle:calculadora:salida.html.twig', array(
            'arrParam'  => $arrParam,
            'total'     => $total,
        ));
    }

}
