<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Troiswa\BackBundle\Entity\Marque;
use Troiswa\BackBundle\Form\MarqueType;

/**
 * Marque controller.
 *
 * @Route("/marque")
 */
class MarqueController extends Controller
{

    /**
     * Lists all Marque entities.
     *
     * @Route("/", name="marque")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TroiswaBackBundle:Marque')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Marque entity.
     *
     * @Route("/", name="marque_create")
     * @Method("POST")
     * @Template("TroiswaBackBundle:Marque:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Marque();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('marque_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Marque entity.
     *
     * @param Marque $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Marque $entity)
    {
        $form = $this->createForm(new MarqueType(), $entity, array(
            'action' => $this->generateUrl('marque_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Marque entity.
     *
     * @Route("/new", name="marque_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Marque();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Marque entity.
     *
     * @Route("/{id}", name="marque_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Marque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marque entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Marque entity.
     *
     * @Route("/{id}/edit", name="marque_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Marque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marque entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Marque entity.
    *
    * @param Marque $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Marque $entity)
    {
        $form = $this->createForm(new MarqueType(), $entity, array(
            'action' => $this->generateUrl('marque_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Marque entity.
     *
     * @Route("/{id}", name="marque_update")
     * @Method("PUT")
     * @Template("TroiswaBackBundle:Marque:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TroiswaBackBundle:Marque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marque entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('marque_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Marque entity.
     *
     * @Route("/{id}", name="marque_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TroiswaBackBundle:Marque')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Marque entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('marque'));
    }

    /**
     * Creates a form to delete a Marque entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('marque_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
