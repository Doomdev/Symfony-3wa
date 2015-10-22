<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Troiswa\BackBundle\Entity\Tags;
use Troiswa\BackBundle\Form\TagsType;

/**
 * Tags controller.
 *
 */
class TagsController extends Controller
{

    /**
     * Lists all Tags entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroiswaBackBundle:Tags')->findAll();

        return $this->render('TroiswaBackBundle:Tags:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Tags entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Tags();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tags_show', array('id' => $entity->getId())));
        }

        return $this->render('TroiswaBackBundle:Tags:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Tags entity.
     *
     * @param Tags $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tags $entity)
    {
        $form = $this->createForm(new TagsType(), $entity, array(
            'action' => $this->generateUrl('tags_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tags entity.
     *
     */
    public function newAction()
    {
        $entity = new Tags();
        $form   = $this->createCreateForm($entity);

        return $this->render('TroiswaBackBundle:Tags:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tags entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TroiswaBackBundle:Tags:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tags entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TroiswaBackBundle:Tags:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Tags entity.
    *
    * @param Tags $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tags $entity)
    {
        $form = $this->createForm(new TagsType(), $entity, array(
            'action' => $this->generateUrl('tags_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Tags entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Tags')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tags entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tags_edit', array('id' => $id)));
        }

        return $this->render('TroiswaBackBundle:Tags:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Tags entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroiswaBackBundle:Tags')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tags entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tags'));
    }

    /**
     * Creates a form to delete a Tags entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tags_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}