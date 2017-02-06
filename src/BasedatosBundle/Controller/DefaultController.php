<?php

namespace BasedatosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BasedatosBundle:Default:index.html.twig');
    }
}
