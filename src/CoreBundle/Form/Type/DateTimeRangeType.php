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
class DateTimeRangeType extends \Sonata\Form\Type\DateTimeRangeType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        @trigger_error(
            'The '.__NAMESPACE__.'\DateTimeRangeType class is deprecated since version 3.13.0 and will be removed in 4.0.'
            .' Use Sonata\Form\Type\DateTimeRangeType instead.',
            E_USER_DEPRECATED
        );

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'sonata_type_datetime_range_legacy';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field_options' => [],
            'field_options_start' => [],
            'field_options_end' => [],
            'field_type' => DateTimeType::class,
        ]);
    }
}
