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

use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionTypeTest extends TypeTestCase
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

        $type = new CollectionType();

        $type->buildForm($formBuilder, [
            'modifiable' => false,
            'type' => TextType::class,
            'type_options' => [],
            'pre_bind_data_callback' => null,
            'btn_add' => 'link_add',
            'btn_catalogue' => 'SonataCoreBundle',
        ]);
    }

    public function testGetParent(): void
    {
        $form = new CollectionType();

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    public function testGetDefaultOptions(): void
    {
        $type = new CollectionType();

        $type->configureOptions($optionResolver = new OptionsResolver());

        $options = $optionResolver->resolve();

        $this->assertFalse($options['modifiable']);
        $this->assertSame(TextType::class, $options['type']);
        $this->assertCount(0, $options['type_options']);
        $this->assertSame('link_add', $options['btn_add']);
        $this->assertSame('SonataCoreBundle', $options['btn_catalogue']);
        $this->assertNull($options['pre_bind_data_callback']);
    }
}
