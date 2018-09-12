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

use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanTypeTest extends TypeTestCase
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

        $type = new BooleanType();

        $type->buildForm($formBuilder, [
            'transform' => false,
            'translation_domain' => 'SonataCoreBundle',
        ]);
    }

    public function testGetParent(): void
    {
        $form = new BooleanType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions(): void
    {
        $type = new BooleanType();

        $this->assertSame(ChoiceType::class, $type->getParent());

        $type->configureOptions($optionResolver = new OptionsResolver());

        $options = $optionResolver->resolve();

        $this->assertCount(2, $options['choices']);
    }

    public function testAddTransformerCall(): void
    {
        $type = new BooleanType();

        $type->configureOptions($optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->once())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve([
            'transform' => true,
        ]));
    }

    /**
     * The default behavior is not to transform to real boolean value .... don't ask.
     */
    public function testDefaultBehavior(): void
    {
        $type = new BooleanType();

        $type->configureOptions($optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->never())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve([]));
    }

    public function testOptions(): void
    {
        $type = new BooleanType();

        $type->configureOptions($optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->never())->method('addModelTransformer');

        $resolvedOptions = $optionResolver->resolve([
            'translation_domain' => 'fooTrans',
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
        ]);

        $type->buildForm($builder, $resolvedOptions);

        $expectedOptions = [
            'transform' => false,
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
            'translation_domain' => 'fooTrans',
        ];

        $this->assertSame($expectedOptions, $resolvedOptions);
    }
}
