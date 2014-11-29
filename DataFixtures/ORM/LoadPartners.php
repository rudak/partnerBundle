<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Rudak\BlogBundle\Utils\Syllabeur;
use Rudak\PartnerBundle\Entity\Partner;

class LoadPartners extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $partners = array();
        for ($i = 0; $i < 80; $i++) {
            $partners[$i] = New Partner();
            $partners[$i]->setName(Syllabeur::getMots(rand(1, 2)));
            $partners[$i]->setDescription(Syllabeur::getMots(8));
            $partners[$i]->setUrl(Syllabeur::getSyllabes(5));
            $partners[$i]->setPicture($this->getReference('partnerPicture_' . $i));
            $partners[$i]->setCategory($this->getReference('partnerCateg_' . rand(0, 5)));
            $manager->persist($partners[$i]);
            echo '.';
        }
        echo "\n";
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 106;
    }
}