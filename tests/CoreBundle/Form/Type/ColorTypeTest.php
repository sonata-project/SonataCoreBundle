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
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * NEXT_MAJOR: remove this class.
 */
class ColorTypeTest extends TypeTestCase
{
    /**
     * @group legacy
     * @expectedDeprecation The Sonata\CoreBundle\Form\Type\ColorType class is deprecated since version 3.10 and will be removed in 4.0. Use Symfony\Component\Form\Extension\Core\Type\ColorType instead.
     */
    public function testDeprecation()
    {
        if (!class_exists('Symfony\Component\Form\Extension\Core\Type\ColorType')) {
            $this->markTestSkipped('< Symfony 3.4');
        }

        $this->factory->create(ColorType::class);
    }

    /**
     * @group legacy
     * @expectedDeprecation The Sonata\CoreBundle\Form\Type\ColorType class is deprecated since version 3.10 and will be removed in 4.0. Use Symfony\Component\Form\Extension\Core\Type\ColorType instead.
     */
    public function testBuildForm()
    {
        if (!class_exists('Symfony\Component\Form\Extension\Core\Type\ColorType')) {
            $this->markTestSkipped('< Symfony 3.4');
        }

        $formBuilder = $this->getMockBuilder(FormBuilder::class)->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null) {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new ColorType();
        $type->buildForm($formBuilder, []);
    }

    /**
     * @group legacy
     * @expectedDeprecation The Sonata\CoreBundle\Form\Type\ColorType class is deprecated since version 3.10 and will be removed in 4.0. Use Symfony\Component\Form\Extension\Core\Type\ColorType instead.
     */
    public function testSubmitValidData()
    {
        if (!class_exists('Symfony\Component\Form\Extension\Core\Type\ColorType')) {
            $this->markTestSkipped('< Symfony 3.4');
        }

        $form = $this->factory->create(ColorType::class);
        $form->submit('#556b2f');
        $this->assertTrue($form->isSynchronized());
    }

    public function testGetParent()
    {
        $form = new ColorType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }
}
