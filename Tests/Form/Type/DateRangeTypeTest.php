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
use Sonata\CoreBundle\Form\Type\DateRangeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateRangeTypeTest extends TypeTestCase
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

        $type = new DateRangeType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));
        $type->buildForm($formBuilder, array(
            'field_options' => array(),
            'field_options_start' => array(),
            'field_options_end' => array(),
            'field_type' => 'Symfony\Component\Form\Extension\Core\Type\DateType',
        ));
    }

    public function testGetParent()
    {
        $form = new DateRangeType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new DateRangeType($this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertSame('sonata_type_date_range', $type->getName());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $this->assertSame(
            array(
                'field_options' => array(),
                'field_options_start' => array(),
                'field_options_end' => array(),
                'field_type' => 'Symfony\Component\Form\Extension\Core\Type\DateType',
            ), $options);
    }
}
