<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\PartnerBundle\Entity\Category;
use Rudak\BlogBundle\Utils\Syllabeur;

class LoadCategories extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $categs = array();
        for ($i = 0; $i < 6; $i++) {

            $categs[$i] = New Category();
            $categs[$i]->setName(Syllabeur::getMots(rand(1, 2)));

            $manager->persist($categs[$i]);
            $this->addReference('partnerCateg_' . $i, $categs[$i]);
            echo "reference ajoutee : " . 'partnerCateg_' . $i . "\n";
        }
        echo "\n";
        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 102;
    }
}