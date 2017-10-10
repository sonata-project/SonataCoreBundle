<?php

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
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImmutableArrayTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
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

        $this->assertSame('sonata_type_immutable_array', $type->getName());

        $this->assertSame('Symfony\Component\Form\Extension\Core\Type\FormType', $type->getParent());

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

        $builder = $this->createMock('Symfony\Component\Form\Test\FormBuilderInterface');
        $builder->expects($this->once())->method('add')->with(
            $this->callback(function ($name) {
                return $name === 'ttl';
            }),
            $this->callback(function ($name) {
                return 'Symfony\Component\Form\Extension\Core\Type\TextType';
            }),
            $this->callback(function ($name) {
                return $name === [1 => '1'];
            })
        );

        $self = $this;
        $optionsCallback = function ($builder, $name, $type, $extra) use ($self) {
            $self->assertEquals(['foo', 'bar'], $extra);
            $self->assertEquals($name, 'ttl');
            $self->assertEquals($type, 'Symfony\Component\Form\Extension\Core\Type\TextType');
            $self->assertInstanceOf('Symfony\Component\Form\Test\FormBuilderInterface', $builder);

            return ['1' => '1'];
        };

        $options = [
            'keys' => [
                [
                    'ttl',
                    'Symfony\Component\Form\Extension\Core\Type\TextType',
                    $optionsCallback,
                    'foo',
                    'bar',
                ],
            ],
        ];

        $type->buildForm($builder, $options);
    }

    public function testWithIncompleteOptions()
    {
        // NEXT_MAJOR: remove the condition
        if (!method_exists('Symfony\Component\OptionsResolver\OptionsResolver', 'setDefault')) {
            $this->markTestSkipped('closure validation is not available');
        }

        $optionsResolver = new OptionsResolver();

        $type = new ImmutableArrayType();
        $type->configureOptions($optionsResolver);

        $this->setExpectedException(
            'Symfony\Component\OptionsResolver\Exception\InvalidOptionsException',
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
                'Symfony\Component\Form\FormBuilderInterface'
            )->getMock()]])
        );
    }
}
