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
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangePickerTypeTest extends TypeTestCase
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

        $type = new DateRangePickerType($this->getMock('Symfony\Component\Translation\TranslatorInterface'));
        $type->buildForm($formBuilder, array(
            'field_options' => array(),
            'field_options_start' => array(),
            'field_options_end' => array(),
            'field_type' => 'Sonata\CoreBundle\Form\Type\DatePickerType',
        ));
    }

    public function testGetParent()
    {
        $form = new DateRangePickerType($this->getMock('Symfony\Component\Translation\TranslatorInterface'));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new DateRangePickerType($this->getMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertSame('sonata_type_date_range_picker', $type->getName());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $this->assertSame(
            array(
                'field_options' => array(),
                'field_options_start' => array(),
                'field_options_end' => array(),
                'field_type' => 'Sonata\CoreBundle\Form\Type\DatePickerType',
            ), $options);
    }
}
