<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rudak\UtilsBundle\FakeContentGenerator;
use Rudak\UtilsBundle\Namer;
use Rudak\UtilsBundle\UrlMaker;
use Rudak\PartnerBundle\Entity\Partner;

class LoadPartners extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        echo "Creation des partenaires :\n";
        $partners = array();

        for ($i = 0; $i <= LoadPartnerPictures::NOMBRE_IMAGES; $i++) {
            $partners[$i] = New Partner();
            $partners[$i]->setName(Namer::getLastName() . ' ' . Namer::getFirstName());
            $partners[$i]->setDescription(FakeContentGenerator::getSentence());
            $partners[$i]->setUrl(UrlMaker::getRandUrl());
            $partners[$i]->setCurrent(true);
            $partners[$i]->setPicture($this->getReference(LoadPartnerPictures::getReferenceName($i)));
            $partners[$i]->setCategory($this->getReference(LoadCategories::getReferenceName(rand(0, 5))));
            $manager->persist($partners[$i]);
            echo ' - ' . $partners[$i]->getName() . "\n";
        }
        echo "\n";
        $manager->flush();
        echo "TERMINE\n -------------------- \n";

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 906;
    }
}