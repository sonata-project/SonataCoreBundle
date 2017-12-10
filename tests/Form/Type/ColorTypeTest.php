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

use Sonata\CoreBundle\Form\Type\ColorType;
use Symfony\Component\Form\Test\TypeTestCase;

class ColorTypeTest extends TypeTestCase
{
    public function testBuildForm(): void
    {
        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null): void {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new ColorType();
        $type->buildForm($formBuilder, []);
    }

    public function testSubmitValidData(): void
    {
        $form = $this->factory->create(ColorType::class);
        $form->submit('#556b2f');
        $this->assertTrue($form->isSynchronized());
    }

    public function testGetParent(): void
    {
        $form = new ColorType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }
}
