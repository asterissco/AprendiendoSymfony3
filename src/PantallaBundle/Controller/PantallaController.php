<?php

namespace PantallaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PantallaController extends Controller
{


    public function indexAction(Request $request){
        return $this->render('PantallaBundle:pantalla:index.html.twig');
    }


    public function resultadoAction(Request $request){

        $arrData    = $request->request->all();
        $resultado  = $arrData['numero1']+$arrData['numero2'];

        $arrRandom      = array();
        $arrRandom[]    = "El";
        $arrRandom[]    = "dia";
        $arrRandom[]    = "que";
        $arrRandom[]    = "conozcas";
        $arrRandom[]    = "a";
        $arrRandom[]    = "alguien";

        $hora           = time();

        return $this->render('PantallaBundle:pantalla:resultado.html.twig', array(
            'arrData'       => $arrData,
            'resultado'     => $resultado,
            'random'        => $arrRandom,
            'hora'          => $hora
        ));

    }


}
