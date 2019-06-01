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
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Hugo Briand <briand@ekino.com>
 *
 * @group legacy
 */
class DatePickerTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formBuilder = $this->getMockBuilder(FormBuilder::class)->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->willReturnCallback(function ($name, $type = null) {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            });

        $type = new DatePickerType(
            $this->createMock(MomentFormatConverter::class),
            $this->createMock(TranslatorInterface::class)
        );
        $type->buildForm($formBuilder, [
            'dp_pick_time' => false,
            'format' => DateType::DEFAULT_FORMAT,
        ]);
    }

    public function testGetParent()
    {
        $form = new DatePickerType(
            $this->createMock(MomentFormatConverter::class),
            $this->createMock(TranslatorInterface::class)
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetName()
    {
        $type = new DatePickerType(new MomentFormatConverter(), $this->createMock(TranslatorInterface::class));

        $this->assertSame('sonata_type_date_picker_legacy', $type->getName());
    }

    /**
     * @group legacy
     */
    public function testConstructorLegacy()
    {
        $type = new DatePickerType(new MomentFormatConverter());

        $this->assertSame('sonata_type_date_picker_legacy', $type->getName());
    }

    public function testSubmitValidData()
    {
        \Locale::setDefault('en');
        $form = $this->factory->create(DatePickerType::class, new \DateTime('2018-06-03'), [
            'format' => \IntlDateFormatter::LONG,
        ]);

        $this->assertSame('June 3, 2018', $form->getViewData());
        $form->submit('June 5, 2018');
        $this->assertSame('2018-06-05', $form->getData()->format('Y-m-d'));
        $this->assertTrue($form->isSynchronized());
    }

    protected function getExtensions()
    {
        $translator = $this->createMock(TranslatorInterface::class);
        $translator->method('getLocale')->willReturn('en');

        $type = new DatePickerType(new MomentFormatConverter(), $translator);

        return [
            new PreloadedExtension([$type], []),
        ];
    }
}
