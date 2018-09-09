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

abstract class BaseStatusType extends AbstractType
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $getter;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $class
     * @param string $getter
     * @param string $name
     */
    public function __construct($class, $getter, $name)
    {
        $this->class = $class;
        $this->getter = $getter;
        $this->name = $name;
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix()
    {
        return $this->name;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $choices = \call_user_func([$this->class, $this->getter]);

        // choice_as_value options is not needed in SF 3.0+
        if ($resolver->isDefined('choices_as_values')) {
            $resolver->setDefault('choices_as_values', true);
        }

        $resolver->setDefaults([
            'choices' => $choices,
        ]);
    }
}
