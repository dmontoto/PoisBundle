<?php

namespace Dmontoto\GmapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PoiType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('latitude')
            ->add('longitude')
            ->add('description')
            ->add('poiCategory','entity', array('class'=>'Dmontoto\GmapsBundle\Entity\PoiCategory', 'property'=>'id',))
        ;
    }

    public function getName()
    {
        return 'dmontoto_gmapsbundle_poitype';
    }
}
