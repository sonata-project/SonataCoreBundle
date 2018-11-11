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

use Sonata\CoreBundle\Color\Colors;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

@trigger_error(
    'The '.__NAMESPACE__.'\ColorSelectorType class is deprecated since version 3.5 and will be removed in 4.0.'
    .' Use '.__NAMESPACE__.'\ColorType instead.',
    E_USER_DEPRECATED
);

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since version 3.5, to be removed in 4.0. Use ColorType instead
 */
class ColorSelectorType extends AbstractType
{
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
        $resolver->setDefaults([
            'choices' => array_flip(Colors::getAll()),
            'choices_as_values' => true,
            'translation_domain' => 'SonataCoreBundle',
            'preferred_choices' => [
                Colors::BLACK,
                Colors::BLUE,
                Colors::GRAY,
                Colors::GREEN,
                Colors::ORANGE,
                Colors::PINK,
                Colors::PURPLE,
                Colors::RED,
                Colors::WHITE,
                Colors::YELLOW,
            ],
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_color_selector';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
