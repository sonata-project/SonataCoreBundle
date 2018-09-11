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

use Sonata\CoreBundle\Form\DataTransformer\BooleanTypeToBooleanTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BooleanType extends AbstractType
{
    public const TYPE_YES = 1;

    public const TYPE_NO = 2;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['transform']) {
            $builder->addModelTransformer(new BooleanTypeToBooleanTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'transform' => false,
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [
                'label_type_yes' => self::TYPE_YES,
                'label_type_no' => self::TYPE_NO,
            ],
            'translation_domain' => 'SonataCoreBundle',
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sonata_type_boolean';
    }
}
