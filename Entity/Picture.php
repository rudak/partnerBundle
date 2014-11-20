<?php

namespace Rudak\PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Rudak\PartnerBundle\Utils\Resizer;

/**
 * Picture
 *
 * @ORM\Table(name="rudakPartner_picture")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Rudak\PartnerBundle\Entity\PictureRepository")
 */
class Picture
{

    private $defaultImagePath = 'no-picture.jpg';
    private $dir = 'uploads/partners';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Assert\Image(
     *      minWidth = 500,
     *      minWidthMessage = "La largeur de l'image est insufisante ({{ width }}px). La largeur minimum est de {{ min_width }}px.",
     *      minHeight = 350,
     *      minHeightMessage = "La hauteur de l'image est insufisante ({{ width }}px). La hauteur minimum est de {{ min_width }}px.",
     *      maxSize="6M"
     * )
     */
    private $file;
    private $temp;

    public function __construct()
    {

    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename   = substr(sha1(uniqid(mt_rand(), true)), 0, 10);
            $this->path = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        $this->compressFile();

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            if ($this->temp != $this->defaultImagePath) {
                unlink($this->getUploadRootDir() . '/' . $this->temp);
            }
            // clear the temp image path
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            if ($this->temp != $this->getDefaultImagePath()) {
                unlink($this->temp);
            }
        }
    }

    private function compressFile()
    {
        if (is_file($this->getAbsolutePath())) {
            $resizer = new Resizer($this->getAbsolutePath());
            $resizer->resizeImage(1100, 840);
            $resizer->saveImage($this->getAbsolutePath(), 85);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getDefaultImagePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->defaultImagePath;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return $this->dir;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }


}