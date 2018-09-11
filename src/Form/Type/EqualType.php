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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EqualType extends AbstractType
{
    public const TYPE_IS_EQUAL = 1;

    public const TYPE_IS_NOT_EQUAL = 2;

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [
                'label_type_equals' => self::TYPE_IS_EQUAL,
                'label_type_not_equals' => self::TYPE_IS_NOT_EQUAL,
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sonata_type_equal';
    }
}
