<?php
namespace Rudak\PartnerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Rudak\PartnerBundle\Entity\Picture;
use Rudak\PictureGrabber\Model\PictureGrabber;

class LoadPartnerPictures extends AbstractFixture implements OrderedFixtureInterface
{
    const NOMBRE_IMAGES = 25;
    const REFERENCE_NAME = 'RdkPartnerPicture_';
    const PICTURE_PREFIX = 'rp_';

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $entities = array();
        $url      = "http://lorempixel.com/%s/%s/";

        echo "Creation des images de partenaires : \n";

        for ($i = 0; $i <= self::NOMBRE_IMAGES; $i++) {
            $entities[$i] = New Picture();

            $url = sprintf($url, rand(290, 380), rand(300, 400));

            $pc = new PictureGrabber($url, $entities[$i]->getUploadDir(), self::PICTURE_PREFIX);

            if ($pc->getImage() === true) {
                $image = $pc->getFileName();
            } else {
                echo 'Erreur : ' . $pc->getError() . "\n";
                $image = $entities[$i]->getDefaultImagePath();
            }

            $entities[$i]->setPath($image);

            $ref = self::getReferenceName($i);
            $this->addReference($ref, $entities[$i]);

            echo " - " . $ref . "\n";
            $manager->persist($entities[$i]);
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

    public static function getReferenceName($nb = null)
    {
        return self::REFERENCE_NAME . $nb;
    }
}