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

namespace Sonata\Form\Tests\Type;

use Sonata\Form\Type\ImmutableArrayType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormBuilderInterface as TestFormBuilderInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmutableArrayTypeTest extends TypeTestCase
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
            ->willReturnCallback(function ($name, $type = null): void {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            });

        $type = new ImmutableArrayType();
        $type->buildForm($formBuilder, [
            'keys' => [],
        ]);
    }

    public function testGetParent(): void
    {
        $form = new ImmutableArrayType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions(): void
    {
        $type = new ImmutableArrayType();

        $this->assertSame('sonata_type_immutable_array', $type->getBlockPrefix());

        $this->assertSame(FormType::class, $type->getParent());

        $type->configureOptions($resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $expected = [
            'keys' => [],
        ];

        $this->assertSame($expected, $options);
    }

    public function testCallback(): void
    {
        $type = new ImmutableArrayType();

        $builder = $this->createMock(TestFormBuilderInterface::class);
        $builder->expects($this->once())->method('add')->with(
            $this->callback(static function ($name) {
                return 'ttl' === $name;
            }),
            $this->callback(static function ($name) {
                return TextType::class === $name;
            }),
            $this->callback(static function ($name) {
                return $name === [1 => '1'];
            })
        );

        $self = $this;
        $optionsCallback = static function ($builder, $name, $type, $extra) use ($self) {
            $self->assertEquals(['foo', 'bar'], $extra);
            $self->assertEquals($name, 'ttl');
            $self->assertEquals($type, TextType::class);
            $self->assertInstanceOf(TestFormBuilderInterface::class, $builder);

            return ['1' => '1'];
        };

        $options = [
            'keys' => [
                ['ttl', TextType::class, $optionsCallback, 'foo', 'bar'],
            ],
        ];

        $type->buildForm($builder, $options);
    }

    public function testWithIncompleteOptions(): void
    {
        $optionsResolver = new OptionsResolver();

        $type = new ImmutableArrayType();
        $type->configureOptions($optionsResolver);

        $this->expectException(InvalidOptionsException::class);
        $this->expectExceptionMessage(
            'The option "keys" with value array is invalid.'
        );

        $optionsResolver->resolve(['keys' => [['test']]]);
    }

    public function testFormBuilderIsAValidElement(): void
    {
        $optionsResolver = new OptionsResolver();

        $type = new ImmutableArrayType();
        $type->configureOptions($optionsResolver);

        $this->assertArrayHasKey(
            'keys',
            $optionsResolver->resolve(['keys' => [$this->createMock(
                FormBuilderInterface::class
            )]])
        );
    }
}
