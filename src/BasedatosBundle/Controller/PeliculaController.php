<?php

namespace BasedatosBundle\Controller;

use BasedatosBundle\Entity\Pelicula;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pelicula controller.
 *
 */
class PeliculaController extends Controller
{
    /**
     * Lists all pelicula entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $peliculas = $em->getRepository('BasedatosBundle:Pelicula')->findAll();

        return $this->render('pelicula/index.html.twig', array(
            'peliculas' => $peliculas,
        ));
    }

    /**
     * Creates a new pelicula entity.
     *
     */
    public function newAction(Request $request)
    {
        $pelicula = new Pelicula();
        $form = $this->createForm('BasedatosBundle\Form\PeliculaType', $pelicula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pelicula);
            $em->flush($pelicula);

            return $this->redirectToRoute('pelicula_show', array('id' => $pelicula->getId()));
        }

        return $this->render('pelicula/new.html.twig', array(
            'pelicula' => $pelicula,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pelicula entity.
     *
     */
    public function showAction(Pelicula $pelicula)
    {
        $deleteForm = $this->createDeleteForm($pelicula);

        return $this->render('pelicula/show.html.twig', array(
            'pelicula' => $pelicula,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pelicula entity.
     *
     */
    public function editAction(Request $request, Pelicula $pelicula)
    {
        $deleteForm = $this->createDeleteForm($pelicula);
        $editForm = $this->createForm('BasedatosBundle\Form\PeliculaType', $pelicula);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pelicula_edit', array('id' => $pelicula->getId()));
        }

        return $this->render('pelicula/edit.html.twig', array(
            'pelicula' => $pelicula,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pelicula entity.
     *
     */
    public function deleteAction(Request $request, Pelicula $pelicula)
    {
        $form = $this->createDeleteForm($pelicula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pelicula);
            $em->flush($pelicula);
        }

        return $this->redirectToRoute('pelicula_index');
    }

    /**
     * Creates a form to delete a pelicula entity.
     *
     * @param Pelicula $pelicula The pelicula entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pelicula $pelicula)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pelicula_delete', array('id' => $pelicula->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
