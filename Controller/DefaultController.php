<?php

namespace Rudak\PartnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $categs = $this->getDoctrine()->getManager()
            ->getRepository('RudakPartnerBundle:Category')
            ->getCategories();
        $this->get('MenuBundle.Handler')->setActiveItem('Partenaires');
        return $this->render('RudakPartnerBundle:Default:front-list.html.twig', array(
            'categs' => $categs
        ));
    }

    public function showAction($id, $slug)
    {
        $partner = $this->getDoctrine()->getManager()
            ->getRepository('RudakPartnerBundle:Partner')
            ->getPartnerById($id);

        $this->get('MenuBundle.Handler')->setActiveItem('Partenaires');

        return $this->render('RudakPartnerBundle:Default:show.html.twig', array(
            'partner' => $partner
        ));
    }

    public function devenirAction()
    {
        $this->get('MenuBundle.Handler')->setActiveItem('Partenaires');

        return $this->render('RudakPartnerBundle:Default:devenir.html.twig');
    }

    public function randPartnerAction()
    {
        $partner = $this->getDoctrine()->getManager()
            ->getRepository('RudakPartnerBundle:Partner')
            ->getRandPartner();

        return $this->render('RudakPartnerBundle:Render:rand-partner.html.twig', array(
            'partner' => $partner
        ));
    }

    public function randPartnersAction()
    {
        $partners = $this->getDoctrine()->getManager()
            ->getRepository('RudakPartnerBundle:Partner')
            ->getRandPartners();

        return $this->render('RudakPartnerBundle:Render:rand-partners.html.twig', array(
            'partners' => $partners
        ));
    }
}
