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

namespace Sonata\CoreBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Sonata\CoreBundle\DependencyInjection\Compiler\FormFactoryCompilerPass;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 * @group legacy
 */
final class FormFactoryCompilerPassTest extends AbstractCompilerPassTestCase
{
    public function setUp()
    {
        if (!class_exists(FormPass::class)) {
            $this->markTestSkipped();
        }
        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormFactoryCompilerPass());
    }

    public function testProcessWithContainerHasNoFormExtensionDefinition()
    {
        $formType = new Definition();
        $formType->addTag('form.type');
        $this->setDefinition('foo', $formType);
        $this->setDefinition('bar', $formType);

        $formTypeExtension = new Definition();
        $formTypeExtension->addTag('form.type_extension');
        $this->setDefinition('baz', $formTypeExtension);
        $this->setDefinition('caz', $formTypeExtension);

        $this->compile();

        $taggedFormTypes = $this->container->getParameter('sonata.core.form.types');
        $this->assertSame($taggedFormTypes, ['foo', 'bar']);

        $taggedFormTypes = $this->container->getParameter('sonata.core.form.type_extensions');
        $this->assertSame($taggedFormTypes, ['baz', 'caz']);
    }

    public function testProcessWithContainerHasFormExtensionDefinition()
    {
        $formExtension = new Definition(null, [null, null, null, null]);
        $this->setDefinition('form.extension', $formExtension);

        $formType = new Definition();
        $formType->addTag('form.type');
        $this->setDefinition('foo', $formType);

        $sonataFormExtension = new Definition(null, [null, null, null, null]);
        $this->setDefinition('sonata.core.form.extension.dependency', $sonataFormExtension);

        $this->compile();

        $this->assertSame($sonataFormExtension, $this->container->getDefinition('form.extension'));

        $this->assertContains('foo', $sonataFormExtension->getArgument(1));
        $this->assertSame([], $sonataFormExtension->getArgument(2));
        $this->assertSame([], $sonataFormExtension->getArgument(3));
    }
}
