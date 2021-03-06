<?php

namespace Rudak\PartnerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Rudak\PartnerBundle\Entity\Partner;
use Rudak\PartnerBundle\Form\PartnerType;

/**
 * Partner controller.
 *
 */
class PartnerController extends Controller
{

    /**
     * Lists all Partner entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RudakPartnerBundle:Partner')->getPartnersList();

        return $this->render('RudakPartnerBundle:Partner:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Partner entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Partner();
        $form   = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Partenaire créé avec succès !'
            );
            $this->logging($this->getUser()->getUsername(), sprintf('Ajout d\'un partenaire [#%d]', $entity->getId()), 'Partners');

            return $this->redirect($this->generateUrl('admin_partners_show', array('id' => $entity->getId())));
        }

        return $this->render('RudakPartnerBundle:Partner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Partner entity.
     *
     * @param Partner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('admin_partners_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Créer',
            'attr'  => array(
                'class' => 'btn btn-success'
            )
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Partner entity.
     *
     */
    public function newAction()
    {
        $entity = new Partner();
        $form   = $this->createCreateForm($entity);

        return $this->render('RudakPartnerBundle:Partner:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Partner entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakPartnerBundle:Partner:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $editForm   = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('RudakPartnerBundle:Partner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Partner entity.
     *
     * @param Partner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('admin_partners_update', array('id' => $entity->getId())),
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
     * Edits an existing Partner entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RudakPartnerBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Partenaire modifié avec succès !'
            );
            $this->logging($this->getUser()->getUsername(), sprintf('Modification d\'un partenaire [#%d]', $entity->getId()), 'Partners');

            return $this->redirect($this->generateUrl('admin_partners_edit', array('id' => $id)));
        }

        return $this->render('RudakPartnerBundle:Partner:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Partner entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em     = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RudakPartnerBundle:Partner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partner entity.');
            }

            $this->logging($this->getUser()->getUsername(), sprintf('Suppression d\'un partenaire [#%d]', $entity->getId()), 'Partners');

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Partenaire supprimé avec succès !'
            );
        }

        return $this->redirect($this->generateUrl('admin_partners'));
    }

    /**
     * Creates a form to delete a Partner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_partners_delete', array('id' => $id)))
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
