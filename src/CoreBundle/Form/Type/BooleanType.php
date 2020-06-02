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
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
 */
class BooleanType extends \Sonata\Form\Type\BooleanType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        @trigger_error(
            'The '.__NAMESPACE__.'\BooleanType class is deprecated since version 3.13.0 and will be removed in 4.0.'
            .' Use Sonata\Form\Type\BooleanType instead.',
            E_USER_DEPRECATED
        );

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'sonata_type_boolean_legacy';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $defaultOptions = [
            'transform' => false,
            /*
             * NEXT_MAJOR: remove this block.
             * @deprecated since sonata-project/form-extensions 0.x, to be removed in 1.0.
             */
            'catalogue' => 'SonataCoreBundle',
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [
                'label_type_yes' => self::TYPE_YES,
                'label_type_no' => self::TYPE_NO,
            ],
            // Use directly translation_domain
            'translation_domain' => static function (Options $options) {
                if ($options['catalogue']) {
                    return $options['catalogue'];
                }

                return $options['translation_domain'];
            },
        ];

        $resolver->setDefaults($defaultOptions);
    }
}
