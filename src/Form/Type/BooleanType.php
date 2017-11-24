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

use Sonata\CoreBundle\Form\DataTransformer\BooleanTypeToBooleanTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanType extends AbstractType
{
    const TYPE_YES = 1;

    const TYPE_NO = 2;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['transform']) {
            $builder->addModelTransformer(new BooleanTypeToBooleanTransformer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaultOptions = [
            'transform' => false,
            /*
             * NEXT_MAJOR: remove this block.
             * @deprecated Deprecated as of SonataCoreBundle 2.3.10, to be removed in 4.0.
             */
            'catalogue' => 'SonataCoreBundle',
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [
                'label_type_yes' => self::TYPE_YES,
                'label_type_no' => self::TYPE_NO,
            ],
            // Use directly translation_domain in SonataCoreBundle 4.0
            'translation_domain' => function (Options $options) {
                if ($options['catalogue']) {
                    return $options['catalogue'];
                }

                return $options['translation_domain'];
            },
        ];

        // choice_as_value options is not needed in SF 3.0+
        if (method_exists(FormTypeInterface::class, 'setDefaultOptions')) {
            $defaultOptions['choices_as_values'] = true;
        }

        $resolver->setDefaults($defaultOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
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
        return 'sonata_type_boolean';
    }
}
