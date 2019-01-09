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
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormBuilderInterface as TestFormBuilderInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @group legacy
 */
class ImmutableArrayTypeTest extends TypeTestCase
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

        $type = new ImmutableArrayType();
        $type->buildForm($formBuilder, [
            'keys' => [],
        ]);
    }

    public function testGetParent()
    {
        $form = new ImmutableArrayType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new ImmutableArrayType();

        $this->assertSame('sonata_type_immutable_array_legacy', $type->getName());

        $this->assertSame(version_compare(Kernel::VERSION, '2.8', '<') ? 'form' : FormType::class, $type->getParent());

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $expected = [
            'keys' => [],
        ];

        $this->assertSame($expected, $options);
    }

    public function testCallback()
    {
        $type = new ImmutableArrayType();

        $builder = $this->createMock(TestFormBuilderInterface::class);
        $builder->expects($this->once())->method('add')->with(
            $this->callback(function ($name) {
                return 'ttl' === $name;
            }),
            $this->callback(function ($name) {
                return TextType::class === $name;
            }),
            $this->callback(function ($name) {
                return $name === [1 => '1'];
            })
        );

        $self = $this;
        $optionsCallback = function ($builder, $name, $type, $extra) use ($self) {
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

    public function testWithIncompleteOptions()
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

    public function testFormBuilderIsAValidElement()
    {
        $optionsResolver = new OptionsResolver();

        $type = new ImmutableArrayType();
        $type->configureOptions($optionsResolver);

        $this->assertArrayHasKey(
            'keys',
            $optionsResolver->resolve(['keys' => [$this->getMockBuilder(
                FormBuilderInterface::class
            )->getMock()]])
        );
    }
}
