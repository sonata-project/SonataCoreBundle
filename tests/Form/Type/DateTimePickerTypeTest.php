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

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Date\MomentFormatConverter;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class DateTimePickerTypeTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testBuildForm(): void
    {
        $formBuilder = $this->createMock(FormBuilder::class);
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null): void {
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

    public function testGetParent(): void
    {
        $form = new DateTimePickerType(
            $this->createMock(MomentFormatConverter::class),
            $this->createMock(TranslatorInterface::class)
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetName(): void
    {
        $type = new DateTimePickerType(new MomentFormatConverter(), $this->createMock(TranslatorInterface::class));

        $this->assertSame('sonata_type_datetime_picker', $type->getBlockPrefix());
    }
}
