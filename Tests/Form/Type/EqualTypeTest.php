<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EqualTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $mock = $this->getMock('Symfony\Component\Translation\TranslatorInterface');

        $mock->expects($this->exactly(2))
            ->method('trans')
            ->will($this->returnCallback(function ($arg) { return $arg; })
            );

        $type = new EqualType($mock);

        $this->assertEquals('sonata_type_equal', $type->getName());
        $this->assertEquals(
            method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ?
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType' :
                'choice',
            $type->getParent()
        );

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $choices = array(1 => 'label_type_equals', 2 => 'label_type_not_equals');

        if (!method_exists('Symfony\Component\Form\FormTypeInterface', 'setDefaultOptions')) {
            $choices = array_flip($choices);
        }

        $expected = array(
            'choices' => $choices,
        );

        $this->assertEquals($expected, $options);
    }
}
