<?php

namespace AclBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

//componentes de seguridad de ACL
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;



class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em         = $this->getDoctrine()->getManager();
        $objeto     = $em->getRepository('AclBundle:Objeto')->findAll();

        $form = $this->createAclForm();
        $form->handleRequest($request);
        $accion     = null;
        $user       = null;
        $arrComprobarAcl = array();
        if($form->isSubmitted() && $form->isValid()){


            $data       = $form->getData();
            $accion     = $data['accion'];
            $user       = $em->getRepository('SeguridadBundle:User')->findOneBy(array('id'=>$data['user']));
            switch ($accion) {
                case 'asociar':
                    $this->asociarAcl($data);
                    break;
                case 'comprobar':
                    $arrComprobarAcl = $this->comprobarAcl($data);
                    break;
                case 'disociar':
                    $this->disociarAcl($data);
                    break;
            }

        }

        return $this->render('AclBundle:Default:index.html.twig', array(
            'objeto'            => $objeto,
            'formulario'        => $form->createView(),
            'accion'            => $accion,
            'arrComprobarAcl'   => $arrComprobarAcl,
            'user'              => $user
        ));
    }

    private function disociarAcl($data){

        $em         = $this->getDoctrine()->getManager();
        $objeto     = $em->getRepository('AclBundle:Objeto')->findOneBy(array(
            'id'    => $data['objeto'],
        ));
        $usuario    = $em->getRepository('SeguridadBundle:User')->findOneBy(array(
            'id'    => $data['user'],
        ));

        $securityIdentity   = UserSecurityIdentity::fromAccount($usuario);

        // creando la ACL sino existe, lo suyo es agregar los objetos en fixtures
        $aclProvider    = $this->get('security.acl.provider');
        //$objectIdentity = ObjectIdentity::fromDomainObject($objeto);
        try{
            $acl            = $aclProvider->findAcl(ObjectIdentity::fromDomainObject($objeto));
        }catch(\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e){
            throw new Exception("No existe ACL de ese objeto", 1);

        }

        $n=0;
        foreach($acl->getObjectAces() as $index => $ace){

            if($ace->getSecurityIdentity()->equals($securityIdentity))
            {

                $builder = new MaskBuilder($ace->getMask());

                if($data['permiso']=='leer'){
                    $builder->remove('view');
                }
                if($data['permiso']=='editar'){
                    $builder->remove('edit');
                }

                //por lo visto esto no funciona
                //$ace->setMask($builder->get());
                
                $acl->updateObjectAce($index,$builder->get());

             }

            $n++;

        }

        $aclProvider->updateAcl($acl);

    }

    private function asociarAcl($data){

        $em         = $this->getDoctrine()->getManager();
        $objeto     = $em->getRepository('AclBundle:Objeto')->findOneBy(array(
            'id'    => $data['objeto'],
        ));

        $usuario    = $em->getRepository('SeguridadBundle:User')->findOneBy(array(
            'id'    => $data['user'],
        ));


        // creando la ACL sino existe, lo suyo es agregar los objetos en fixtures
        $aclProvider    = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($objeto);
        try{
            $acl            = $aclProvider->findAcl($objectIdentity);
        }catch(\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e){
            $acl            = $aclProvider->createAcl($objectIdentity);
        }


        // recupera la identidad de seguridad del usuario
        // registrado actualmente

        //la siguientes lineas sería para coger al usuario ahora logeado
        //$securityContext    = $this->get('security.context');
        //$user               = $securityContext->getToken()->getUser();
        $securityIdentity   = UserSecurityIdentity::fromAccount($usuario);

        $builder = new MaskBuilder();
        if($data['permiso']=='leer'){
            $builder->add('VIEW');
        }
        if($data['permiso']=='editar'){
            $builder->add('EDIT');
        }

        $mask = $builder->get(); // int(29)

        // otorga permiso de propietario
        $acl->insertObjectAce($securityIdentity, $mask);
        $aclProvider->updateAcl($acl);

        // formal alternativa
        // $identity = new UserSecurityIdentity('johannes', 'AppBundle\Entity\User');
        // $acl->insertObjectAce($identity, $mask);

    }

    private function comprobarAcl($data){

        $em         = $this->getDoctrine()->getManager();
        // $objeto     = $em->getRepository('AclBundle:Objeto')->findOneBy(array(
        //     'id'    => $data['objeto'],
        // ));
        $objeto     = $em->getRepository('AclBundle:Objeto')->findAll();


        $user       = $em->getRepository('SeguridadBundle:User')->findOneBy(array(
            'id'    => $data['user'],
        ));


        $aclProvider        = $this->get('security.acl.provider');

        $oids = array();
        foreach ($objeto as $obj) {
            $flag = true;
            try{
                $oid = ObjectIdentity::fromDomainObject($obj);
                $aclProvider->findAcl($oid);
            }catch(\Exception $e){
                $flag = false;
            }
            if($flag){
                $oids[] = $oid;
            }
        }

        //usa FIND ACL para ver quien tiene reglas en la base de datos
        $aclProvider->findAcls($oids); // preload Acls from database

        //este bloque me permite saber que decisiones se tomarian para un usuario
        //que no fuera el actualmene logeado, hay que crear un objeto que sostenga un o conexto
        //de seguridad que no es el cargarad
        $token          = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $tokenStorage   = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage();
        $tokenStorage->setToken($token);

        $authorizationChecker = new \Symfony\Component\Security\Core\Authorization\AuthorizationChecker(
            $tokenStorage,
            $this->container->get('security.authentication.manager'),
            $this->container->get('debug.security.access.decision_manager')
         );

        $arrObjGranted = array();

        foreach ($objeto as $obj){

            if ($authorizationChecker->isGranted('EDIT', $obj)) {
                $arrObjGranted[$obj->getNombre()]['edit']='si';
            }else {
                $arrObjGranted[$obj->getNombre()]['edit']='no';
            }

            if ($authorizationChecker->isGranted('VIEW', $obj)) {
                $arrObjGranted[$obj->getNombre()]['view']='si';
            }else {
                $arrObjGranted[$obj->getNombre()]['view']='no';
            }

        }

        return $arrObjGranted;

    }

    private function createAclForm(){

        $em         = $this->getDoctrine()->getManager();
        $objeto     = $em->getRepository('AclBundle:Objeto')->findAll();

            foreach($objeto as $obj){   $arrObj[$obj->getNombre()]=$obj->getId();       }

        $em         = $this->getDoctrine()->getManager();
        $usuario    = $em->getRepository('SeguridadBundle:User')->findAll();

            foreach($usuario as $usu){   $arrUsu[$usu->getUsername()]=$usu->getId();    }

        $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->getFormFactory();

        return $formFactory->createBuilder(FormType::Class,null,array(
            'action'    =>$this->generateUrl('acl_homepage'),
            'method'    =>'POST'))
            ->add('objeto',ChoiceType::class,array(
                'required'          => true,
                'choices'           => $arrObj,
            ))
            ->add('user',ChoiceType::class,array(
                'required'          => true,
                'choices'           => $arrUsu,
            ))
            ->add('permiso',ChoiceType::class,array(
                'required' => true,
                'choices' => array(
                    'Leer'          => 'leer',
                    'Editar'        => 'editar',
                ),
            ))
            ->add('accion',ChoiceType::class,array(
                'required' => true,
                'choices' => array(
                    'Asociar'       => 'asociar',
                    'Disociar'    => 'disociar',
                    'Comprobar'     => 'comprobar',
                ),
            ))
            ->getForm();

    }

}
