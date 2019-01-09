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

use Sonata\CoreBundle\Date\MomentFormatConverter;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Hugo Briand <briand@ekino.com>
 *
 * @group legacy
 */
class DateTimePickerTypeTest extends TypeTestCase
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

        $type = new DateTimePickerType(
            $this->createMock(MomentFormatConverter::class),
            $this->createMock(TranslatorInterface::class)
        );

        $type->buildForm($formBuilder, [
            'dp_use_minutes' => true,
            'dp_use_seconds' => true,
            'dp_minute_stepping' => 1,
            'format' => DateTimeType::DEFAULT_DATE_FORMAT,
            'date_format' => null,
        ]);
    }

    public function testGetParent()
    {
        $form = new DateTimePickerType(
            $this->createMock(MomentFormatConverter::class),
            $this->createMock(TranslatorInterface::class)
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetName()
    {
        $type = new DateTimePickerType(new MomentFormatConverter(), $this->createMock(TranslatorInterface::class));

        $this->assertSame('sonata_type_datetime_picker_legacy', $type->getName());
    }

    /**
     * @group legacy
     */
    public function testConstructorLegacy()
    {
        $type = new DateTimePickerType(new MomentFormatConverter());

        $this->assertSame('sonata_type_datetime_picker_legacy', $type->getName());
    }

    public function testSubmitUnmatchingDateFormat()
    {
        \Locale::setDefault('en');
        $form = $this->factory->create(DateTimePickerType::class, new \DateTime('2018-06-03 20:02:03'), [
            'format' => \IntlDateFormatter::NONE,
            'dp_pick_date' => false,
            'dp_use_seconds' => false,
        ]);

        $form->submit('05:23');
        $this->assertFalse($form->isSynchronized());
    }

    public function testSubmitMatchingDateFormat()
    {
        \Locale::setDefault('en');
        $form = $this->factory->create(DateTimePickerType::class, new \DateTime('2018-06-03 20:02:03'), [
            'format' => \IntlDateFormatter::NONE,
            'dp_pick_date' => false,
            'dp_use_seconds' => false,
        ]);

        $this->assertSame('8:02 PM', $form->getViewData());

        $form->submit('5:23 AM');
        $this->assertSame('1970-01-01 05:23:00', $form->getData()->format('Y-m-d H:i:s'));
        $this->assertTrue($form->isSynchronized());
    }

    protected function getExtensions()
    {
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('getLocale')->willReturn('en');

        $type = new DateTimePickerType(new MomentFormatConverter(), $translator);

        return [
            new PreloadedExtension([$type], []),
        ];
    }
}
