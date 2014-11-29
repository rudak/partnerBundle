<?php

namespace Rudak\PartnerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="rudakPartner_category")
 * @ORM\Entity(repositoryClass="Rudak\PartnerBundle\Entity\CategoryRepository")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @ORM\oneToMany(targetEntity="Partner",mappedBy="category")
     */
    private $partners;

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
     * @return Category
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

    public function __toString()
    {
        return $this->name;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partners = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add partners
     *
     * @param \Rudak\PartnerBundle\Entity\Partner $partners
     * @return Category
     */
    public function addPartner(\Rudak\PartnerBundle\Entity\Partner $partners)
    {
        $this->partners[] = $partners;

        return $this;
    }

    /**
     * Remove partners
     *
     * @param \Rudak\PartnerBundle\Entity\Partner $partners
     */
    public function removePartner(\Rudak\PartnerBundle\Entity\Partner $partners)
    {
        $this->partners->removeElement($partners);
    }

    /**
     * Get partners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPartners()
    {
        return $this->partners;
    }
}
