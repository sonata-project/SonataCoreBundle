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
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class DatePickerTypeTest extends TestCase
{
    public function testBuildForm(): void
    {
        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null): void {
                if (null !== $type) {
                    $that->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new DatePickerType(
            $this->createMock('Sonata\CoreBundle\Date\MomentFormatConverter'),
            $this->createMock('Symfony\Component\Translation\TranslatorInterface')
        );
        $type->buildForm($formBuilder, [
            'dp_pick_time' => false,
            'format' => DateType::DEFAULT_FORMAT,
        ]);
    }

    public function testGetParent(): void
    {
        $form = new DatePickerType(
            $this->createMock('Sonata\CoreBundle\Date\MomentFormatConverter'),
            $this->createMock('Symfony\Component\Translation\TranslatorInterface')
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetName(): void
    {
        $type = new DatePickerType(new MomentFormatConverter(), $this->createMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertSame('sonata_type_date_picker', $type->getName());
    }
}
