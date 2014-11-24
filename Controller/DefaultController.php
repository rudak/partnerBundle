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
}
