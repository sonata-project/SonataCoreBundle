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
use Sonata\CoreBundle\Form\Type\BaseStatusType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Choice
{
    public static $list;

    public static function getList()
    {
        return static::$list;
    }
}

class StatusType extends BaseStatusType
{
}

class StatusTypeTest extends TypeTestCase
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

        $type = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type');
        $type->buildForm($formBuilder, [
            'choices' => [],
        ]);
    }

    public function testGetParent(): void
    {
        $form = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type');

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions(): void
    {
        Choice::$list = [
            1 => 'salut',
        ];

        $type = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type');

        $this->assertSame('choice_type', $type->getName());

        $this->assertSame(ChoiceType::class, $type->getParent());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve([]);

        $this->assertArrayHasKey('choices', $options);
        $this->assertSame($options['choices'], [1 => 'salut']);
    }

    public function testGetDefaultOptionsWithValidFlip(): void
    {
        Choice::$list = [
            1 => 'salut',
            2 => 'toi!',
        ];

        $type = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type', true);

        $this->assertSame('choice_type', $type->getName());
        $this->assertSame(ChoiceType::class, $type->getParent());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve([]);

        $this->assertArrayHasKey('choices', $options);
        $this->assertSame($options['choices'], ['salut' => 1, 'toi!' => 2]);
    }

    public function testGetDefaultOptionsWithValidInvalidFlip(): void
    {
        $this->expectException(\RuntimeException::class);

        Choice::$list = [
            1 => 'error',
            2 => 'error',
        ];

        $type = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type', true);

        $this->assertSame('choice_type', $type->getName());
        $this->assertSame(ChoiceType::class, $type->getParent());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve([]);
    }
}
