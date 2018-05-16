<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * DateRangePickerType.
 *
 * @author Andrej Hudec <pulzarraider@gmail.com>
 */
class DateRangePickerType extends DateRangeType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field_options' => [],
            'field_options_start' => [],
            'field_options_end' => [
                'dp_use_current' => false,
            ],
            'field_type' => DatePickerType::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_date_range_picker';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
