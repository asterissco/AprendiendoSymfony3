<?php

namespace SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SeguridadBundle:Default:index.html.twig');
    }

    public function zonaprotegidaAction(){

        return $this->render('SeguridadBundle:Default:zonaprotegida.html.twig');

    }

    public function entrarAction(Request $request){


        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('SeguridadBundle:Default:entrar.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

/*
        $formFactory = Forms::CreateFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        $form = $formFactory->createBuilder()
            ->add('user',TextType::class)
            ->add('password',PasswordType::class)
            ->getForm();

        return $this->render('SeguridadBundle:Default:entrar.html.twig', array(
            'form'      => $form->createView(),
        ));
*/
    }
}
