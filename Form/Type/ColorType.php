<?php
/**
 * Created by PhpStorm.
 * User: Marko Kunic
 * Date: 9/9/17
 * Time: 11:23 AM
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class ColorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ?
            'Symfony\Component\Form\Extension\Core\Type\TextType' :
            'text' // SF <2.8 BC
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sonata_type_color';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
