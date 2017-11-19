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
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTimeRangePickerTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null) {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new DateTimeRangePickerType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));
        $type->buildForm($formBuilder, [
            'field_options' => [],
            'field_options_start' => [],
            'field_options_end' => [],
            'field_type' => DateTimePickerType::class,
        ]);
    }

    public function testGetParent()
    {
        $form = new DateTimeRangePickerType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new DateTimeRangePickerType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertSame('sonata_type_datetime_range_picker', $type->getName());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $this->assertSame(
            [
                'field_options' => [],
                'field_options_start' => [],
                'field_options_end' => [],
                'field_type' => DateTimePickerType::class,
            ], $options);
    }
}
