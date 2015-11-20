<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * DateTimeRangePickerType.
 *
 * @author Andrej Hudec <pulzarraider@gmail.com>
 */
class DateTimeRangePickerType extends DateTimeRangeType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'field_options'       => array(),
            'field_options_start' => array(),
            'field_options_end'   => array(),
            'field_type'          => 'sonata_type_datetime_picker',
        ));
    }

    /**
     * {@inheritdoc}
     * BC for SF < 2.8.
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sonata_type_datetime_range_picker';
    }
}
