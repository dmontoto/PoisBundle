<?php

namespace Dmontoto\GmapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Dmontoto\GmapsBundle\Entity\PoiCategory;
use Dmontoto\GmapsBundle\Form\PoiCategoryType;

/**
 * PoiCategory controller.
 *
 */
class PoiCategoryController extends Controller
{
    /**
     * Lists all PoiCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GmapsBundle:PoiCategory')->findAll();

        return $this->render('GmapsBundle:PoiCategory:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a PoiCategory entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:PoiCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PoiCategory entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GmapsBundle:PoiCategory:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }

    /**
     * Displays a form to create a new PoiCategory entity.
     *
     */
    public function newAction()
    {
        $entity = new PoiCategory();
        $form   = $this->createForm(new PoiCategoryType(), $entity);

        return $this->render('GmapsBundle:PoiCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new PoiCategory entity.
     *
     */
    public function createAction()
    {
        $entity  = new PoiCategory();
        $request = $this->getRequest();
        $form    = $this->createForm(new PoiCategoryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poicategory_show', array('id' => $entity->getId())));
            
        }

        return $this->render('GmapsBundle:PoiCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing PoiCategory entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:PoiCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PoiCategory entity.');
        }

        $editForm = $this->createForm(new PoiCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GmapsBundle:PoiCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing PoiCategory entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GmapsBundle:PoiCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PoiCategory entity.');
        }

        $editForm   = $this->createForm(new PoiCategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('poicategory_edit', array('id' => $id)));
        }

        return $this->render('GmapsBundle:PoiCategory:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PoiCategory entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GmapsBundle:PoiCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PoiCategory entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('poicategory'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
