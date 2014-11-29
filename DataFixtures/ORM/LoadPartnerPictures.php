<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\PartnerBundle\Entity\Picture;


class LoadPartnerPictures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entities = array();
        for ($i = 0; $i < 480; $i++) {
            $entities[$i] = New Picture();
            $entities[$i]->setPath('no-image.jpg');

            $this->addReference('partnerPicture_' . $i, $entities[$i]);
            $manager->persist($entities[$i]);
            echo ".";
        }
        echo "\n";
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 104;
    }
}