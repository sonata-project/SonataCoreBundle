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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
 */
class EqualType extends \Sonata\Form\Type\EqualType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        @trigger_error(
            'The '.__NAMESPACE__.'\EqualType class is deprecated since version 3.13.0 and will be removed in 4.0.'
            .' Use Sonata\Form\Type\EqualType instead.',
            E_USER_DEPRECATED
        );

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'sonata_type_equal_legacy';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $defaultOptions = [
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [
                'label_type_equals' => self::TYPE_IS_EQUAL,
                'label_type_not_equals' => self::TYPE_IS_NOT_EQUAL,
            ],
        ];

        $resolver->setDefaults($defaultOptions);
    }
}
