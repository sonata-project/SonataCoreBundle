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

use Sonata\CoreBundle\Date\MomentFormatConverter;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Tests\PHPUnit_Framework_TestCase;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class DateTimePickerTypeTest extends PHPUnit_Framework_TestCase
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

        $type = new DateTimePickerType(
            $this->createMock('Sonata\CoreBundle\Date\MomentFormatConverter'),
            $this->createMock('Symfony\Component\Translation\TranslatorInterface')
        );

        $type->buildForm($formBuilder, array(
            'dp_use_minutes' => true,
            'dp_use_seconds' => true,
            'dp_minute_stepping' => 1,
            'format' => DateTimeType::DEFAULT_DATE_FORMAT,
            'date_format' => null,
        ));
    }

    public function testGetParent()
    {
        $form = new DateTimePickerType(
            $this->createMock('Sonata\CoreBundle\Date\MomentFormatConverter'),
            $this->createMock('Symfony\Component\Translation\TranslatorInterface')
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetName()
    {
        $type = new DateTimePickerType(new MomentFormatConverter(), $this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertSame('sonata_type_datetime_picker', $type->getName());
    }
}
