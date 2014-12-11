<?php

namespace Rudak\PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="rudakPartner")
 * @ORM\Entity(repositoryClass="Rudak\PartnerBundle\Entity\PartnerRepository")
 */
class Partner
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Rudak\PartnerBundle\Entity\Category",
     * inversedBy="partners"
     * )
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description",  type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\Valid
     * @var string
     * @ORM\OneToOne(targetEntity="Rudak\PartnerBundle\Entity\Picture",cascade={"remove","persist"})
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255,nullable=true)
     */
    private $url;


    /**
     * @var boolean
     *
     * @ORM\Column(name="current", type="boolean")
     */
    private $current;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Partner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Partner
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Partner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set category
     *
     * @param \Rudak\PartnerBundle\Entity\Category $category
     * @return Partner
     */
    public function setCategory(\Rudak\PartnerBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Rudak\PartnerBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set picture
     *
     * @param \Rudak\PartnerBundle\Entity\Picture $picture
     * @return Partner
     */
    public function setPicture(\Rudak\PartnerBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return \Rudak\PartnerBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return boolean
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * @param boolean $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }


}
