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

use Sonata\CoreBundle\Form\Type\EqualType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class EqualTypeTest extends TypeTestCase
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

        $type = new EqualType($this->createMock(TranslatorInterface::class));
        $type->buildForm($formBuilder, [
            'choices' => [],
        ]);
    }

    public function testGetParent(): void
    {
        $form = new EqualType($this->createMock(TranslatorInterface::class));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions(): void
    {
        $mock = $this->createMock(TranslatorInterface::class);

        $mock->expects($this->exactly(0))
            ->method('trans')
            ->will($this->returnCallback(function ($arg) {
                return $arg;
            })
            );

        $type = new EqualType($mock);

        $this->assertSame('sonata_type_equal', $type->getBlockPrefix());
        $this->assertSame(ChoiceType::class, $type->getParent());

        $type->configureOptions($resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $expected = [
            'choice_translation_domain' => 'SonataCoreBundle',
            'choices' => ['label_type_equals' => 1, 'label_type_not_equals' => 2],
        ];

        $this->assertSame($expected, $options);
    }
}
