<?php

namespace Rudak\PartnerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Rudak\PartnerBundle\Entity\Category;
use Rudak\PartnerBundle\Form\CategoryType;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RudakPartnerBundle:Category')->findAll();

        return $this->render('RudakPartnerBundle:Category:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->logging($this->getUser()->getUsername(), sprintf('Création d\'une galerie [#%d]', $entity->getId()), 'Partners');

            $this->get('session')->getFlashBag()->add(
                'success',
                'Nouvelle catégorie crée avec succès !'
            );

            return $this->redirect($this->generateUrl('admin_partners_categ_show', array('id' => $entity->getId())));
        }

        return $this->render('RudakPartnerBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_partners_categ_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Créer',
            'attr'  => array(
                'class' => 'btn btn-success'
            )));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);

        return $this->render('RudakPartnerBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakPartnerBundle:Category:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakPartnerBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_partners_categ_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Modifier',
            'attr'  => array(
                'class' => 'btn btn-warning'
            )));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Catégorie modifiée avec succès !'
            );
            $this->logging($this->getUser()->getUsername(), sprintf('Modification d\'une galerie [#%d]', $entity->getId()), 'Partners');

            return $this->redirect($this->generateUrl('admin_partners_categ_edit', array('id' => $id)));
        }

        return $this->render('RudakPartnerBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RudakPartnerBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }
            $this->logging($this->getUser()->getUsername(), sprintf('Suppression d\'une galerie [#%d]', $entity->getId()), 'Partners');

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Catégorie \' <strong>' . $entity->getName() . '\'</strong> supprimée !'
            );
        }

        return $this->redirect($this->generateUrl('admin_partners_categ'));
    }

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_partners_categ_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Supprimer',
                'attr'  => array(
                    'class' => 'btn btn-danger'
                )))
            ->getForm();
    }

    private function logging($user, $action, $category)
    {
        try {
            $OwnLogger = $this->get('rudak.own.logger');
            $OwnLogger->addEntry($user, $action, $category, new \DateTime());
        } catch (\Exception $e) {
        }
    }
}
