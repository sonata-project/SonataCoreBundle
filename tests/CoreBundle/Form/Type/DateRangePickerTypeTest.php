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

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\Form\Type\DatePickerType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @group legacy
 */
class DateRangePickerTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formBuilder = $this->getMockBuilder(FormBuilder::class)->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null) {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new DateRangePickerType($this->createMock(TranslatorInterface::class));
        $type->buildForm($formBuilder, [
            'field_options' => [],
            'field_options_start' => [],
            'field_options_end' => [],
            'field_type' => DatePickerType::class,
        ]);
    }

    public function testGetParent()
    {
        $form = new DateRangePickerType($this->createMock(TranslatorInterface::class));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new DateRangePickerType($this->createMock(TranslatorInterface::class));

        $this->assertSame('sonata_type_date_range_picker_legacy', $type->getName());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $this->assertSame(
            [
                'field_options' => [],
                'field_options_start' => [],
                'field_options_end' => [
                    'dp_use_current' => false,
                ],
                'field_type' => DatePickerType::class,
            ], $options);
    }
}
