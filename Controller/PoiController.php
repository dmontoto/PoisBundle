<?php

namespace Dmontoto\GmapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Dmontoto\GmapsBundle\Entity\Poi;
use Dmontoto\GmapsBundle\Form\PoiType;

/**
 * Poi controller.
 *
 */
class PoiController extends Controller
{
    /**
     * Lists all Poi entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GmapsBundle:Poi')->findAll();

        return $this->render('GmapsBundle:Poi:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Poi entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:Poi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poi entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GmapsBundle:Poi:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new Poi entity.
     *
     */
    public function newAction()
    {
        $entity = new Poi();
        $form   = $this->createForm(new PoiType(), $entity);

        return $this->render('GmapsBundle:Poi:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Poi entity.
     *
     */
    public function createAction()
    {
        $entity  = new Poi();
        $request = $this->getRequest();
        $form    = $this->createForm(new PoiType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poi_show', array('id' => $entity->getId())));
            
        }

        return $this->render('GmapsBundle:Poi:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Poi entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:Poi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poi entity.');
        }

        $editForm = $this->createForm(new PoiType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GmapsBundle:Poi:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Poi entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:Poi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Poi entity.');
        }

        $editForm   = $this->createForm(new PoiType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poi_edit', array('id' => $id)));
        }

        return $this->render('GmapsBundle:Poi:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Poi entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GmapsBundle:Poi')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Poi entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('poi'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
