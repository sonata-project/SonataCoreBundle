<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EqualTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $mock = $this->getMock('Symfony\Component\Translation\TranslatorInterface');

        $mock->expects($this->exactly(2))
            ->method('trans')
            ->will($this->returnCallback(function ($arg) {
                return $arg;
            })
            );

        $type = new EqualType($mock);

        $this->assertSame('sonata_type_equal', $type->getName());
        $this->assertSame(
            LegacyFormHelper::getType(
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                'choice'
            ),
            $type->getParent()
        );

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $choices = array(1 => 'label_type_equals', 2 => 'label_type_not_equals');
        $expected = array(
            'choices' => $choices,
        );

        LegacyFormHelper::fixChoiceOptions($expected);

        $this->assertSame($expected, $options);
    }
}
