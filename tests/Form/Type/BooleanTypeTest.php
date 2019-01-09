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

use Sonata\CoreBundle\Form\FormHelper;
use Sonata\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanTypeTest extends TypeTestCase
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

        $type = new BooleanType();

        $type->buildForm($formBuilder, [
            'transform' => false,

            /*
             * NEXT_MAJOR: remove this block.
             * @deprecated Deprecated as of SonataCoreBundle 2.3.10, to be removed in 4.0.
             */
            'catalogue' => 'SonataCoreBundle',

            // Use directly translation_domain in SonataCoreBundle 4.0
            'translation_domain' => function (Options $options) {
                if ($options['catalogue']) {
                    return $options['catalogue'];
                }

                return $options['translation_domain'];
            },
        ]);
    }

    public function testGetParent()
    {
        $form = new BooleanType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions()
    {
        $type = new BooleanType();

        $this->assertSame(ChoiceType::class, $type->getParent());

        FormHelper::configureOptions($type, $optionResolver = new OptionsResolver());

        $options = $optionResolver->resolve();

        $this->assertCount(2, $options['choices']);
    }

    public function testAddTransformerCall()
    {
        $type = new BooleanType();

        FormHelper::configureOptions($type, $optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->once())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve([
            'transform' => true,
        ]));
    }

    /**
     * The default behavior is not to transform to real boolean value .... don't ask.
     */
    public function testDefaultBehavior()
    {
        $type = new BooleanType();

        FormHelper::configureOptions($type, $optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->never())->method('addModelTransformer');

        $type->buildForm($builder, $optionResolver->resolve([]));
    }

    public function testOptions()
    {
        $type = new BooleanType();

        FormHelper::configureOptions($type, $optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->never())->method('addModelTransformer');

        $resolvedOptions = $optionResolver->resolve([
            'translation_domain' => 'fooTrans',
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
        ]);

        $type->buildForm($builder, $resolvedOptions);

        $expectedOptions = [
            'transform' => false,
            'catalogue' => 'SonataCoreBundle',
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices_as_values' => true,
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
            'translation_domain' => 'fooTrans',
        ];

        if (!method_exists(FormTypeInterface::class, 'setDefaultOptions')) {
            unset($expectedOptions['choices_as_values']);
        }

        $this->assertSame($expectedOptions, $resolvedOptions);
    }

    /**
     * @group legacy
     */
    public function testDeprecatedCatalogueOptionLegacy()
    {
        $type = new BooleanType();

        FormHelper::configureOptions($type, $optionResolver = new OptionsResolver());

        $builder = $this->createMock(FormBuilderInterface::class);
        $builder->expects($this->never())->method('addModelTransformer');

        $resolvedOptions = $optionResolver->resolve([
            'catalogue' => 'fooTrans',
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
        ]);

        $type->buildForm($builder, $resolvedOptions);

        $expectedOptions = [
            'transform' => false,
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices_as_values' => true,
            'catalogue' => 'fooTrans',
            'choices' => [1 => 'foo_yes', 2 => 'foo_no'],
            'translation_domain' => 'fooTrans',
        ];

        if (!method_exists(FormTypeInterface::class, 'setDefaultOptions')) {
            unset($expectedOptions['choices_as_values']);
        }

        $this->assertSame($expectedOptions, $resolvedOptions);
    }
}
