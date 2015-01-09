<?php

namespace Rudak\PartnerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PartnerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Nom'
            ))
            ->add('description', 'textarea')
            ->add('url', 'text', array(
                'label'    => 'Lien de la catégorie',
                'required' => false,
                'attr'     => array(
                    'placeholder' => 'http://...',
                )
            ))
            ->add('category', 'entity', array(
                'label'         => 'Catégorie',
                'class'         => 'RudakPartnerBundle:Category',
                'property'      => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'attr'          => array(
                    'class' => 'selectpicker'
                ),
            ))
            ->add('picture', new PictureType(), array(
                'label'    => false,
                'required' => false
            ))
            ->add('current', 'checkbox', array(
                'required' => false,
                'label'    => 'Partenaire Actuel'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rudak\PartnerBundle\Entity\Partner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rudak_partnerbundle_partner';
    }
}
