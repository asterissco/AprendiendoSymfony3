<?php

namespace PantallaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('PantallaBundle:Default:index.html.twig');
    }
}
