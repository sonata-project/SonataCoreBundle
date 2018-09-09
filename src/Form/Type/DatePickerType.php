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

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
final class DatePickerType extends BasePickerType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array_merge($this->getCommonDefaults(), [
            'dp_pick_time' => false,
            'format' => DateType::DEFAULT_FORMAT,
        ]));
    }

    public function getParent(): string
    {
        return DateType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sonata_type_date_picker';
    }
}
