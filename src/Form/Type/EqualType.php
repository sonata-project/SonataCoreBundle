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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

class EqualType extends AbstractType
{
    const TYPE_IS_EQUAL = 1;

    const TYPE_IS_NOT_EQUAL = 2;

    /**
     * NEXT_MAJOR: remove this property.
     *
     * @var TranslatorInterface|null
     *
     * @deprecated translator property is deprecated since version 3.1, to be removed in 4.0
     */
    protected $translator;

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated translator property is deprecated since version 3.1, to be removed in 4.0
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        // check if class is overloaded and notify about removing deprecated translator
        if (null !== $translator && __CLASS__ !== get_class($this)) {
            @trigger_error(
                'The translator dependency in '.__CLASS__.' is deprecated since 3.1 and will be removed in 4.0. '.
                'Please prepare your dependencies for this change.',
                E_USER_DEPRECATED
            );
        }

        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     *
     * @todo Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
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

        // choice_as_value options is not needed in SF 3.0+
        if (method_exists(FormTypeInterface::class, 'setDefaultOptions')) {
            $defaultOptions['choices_as_values'] = true;
        }

        $resolver->setDefaults($defaultOptions);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_equal';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
