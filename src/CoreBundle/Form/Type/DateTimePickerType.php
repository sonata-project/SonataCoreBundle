<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
 */
class DateTimePickerType extends \Sonata\Form\Type\DateTimePickerType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        @trigger_error(
            'The '.__NAMESPACE__.'\DateTimePickerType class is deprecated since version 3.13.0 and will be removed in 4.0.'
            .' Use Sonata\Form\Type\DateTimePickerType instead.',
            E_USER_DEPRECATED
        );

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'sonata_type_datetime_picker_legacy';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array_merge($this->getCommonDefaults(), [
            'dp_use_minutes' => true,
            'dp_use_seconds' => true,
            'dp_minute_stepping' => 1,
            'format' => DateTimeType::DEFAULT_DATE_FORMAT,
            'date_format' => null,
        ]));

        parent::configureOptions($resolver);
    }
}
