<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\PartnerBundle\Entity\Category;
use Rudak\UtilsBundle\FakeContentGenerator;
use Rudak\UtilsBundle\Namer;
use Rudak\UtilsBundle\Syllabeur;

class LoadCategories extends AbstractFixture implements OrderedFixtureInterface
{
    const NOMBRE_CATEGORIES = 6;
    const REFERENCE_NAME = 'RdkPartnerCateg_';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $categs = array();
        echo "PARTNER BUNDLE\n--------------\n";
        echo "Creation categories : \n";

        for ($i = 0; $i < self::NOMBRE_CATEGORIES; $i++) {

            $categs[$i] = New Category();
            $categs[$i]->setName(FakeContentGenerator::getSmallTitle());

            $manager->persist($categs[$i]);
            $ref = self::getReferenceName($i);
            $this->addReference($ref, $categs[$i]);
            echo ' - ' . $ref . "\n";
        }
        echo "\n";
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 902;
    }


    public static function getReferenceName($nb = null)
    {
        return self::REFERENCE_NAME . $nb;
    }
}