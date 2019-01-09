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
use Sonata\CoreBundle\Form\Type\TranslatableChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @group legacy
 */
class TranslatableChoiceTypeTest extends TypeTestCase
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

        $type = new TranslatableChoiceType($this->createMock(TranslatorInterface::class));
        $type->buildForm($formBuilder, [
            'catalogue' => 'messages',
        ]);
    }

    public function testGetParent()
    {
        $form = new TranslatableChoiceType($this->createMock(TranslatorInterface::class));

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testLegacyGetDefaultOptions()
    {
        $stub = $this->createMock(TranslatorInterface::class);

        $type = new TranslatableChoiceType($stub);

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $this->assertSame(ChoiceType::class, $type->getParent());

        $options = $resolver->resolve(['catalogue' => 'foo']);

        $this->assertSame('foo', $options['catalogue']);
    }
}
