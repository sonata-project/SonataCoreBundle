<?php

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
use Sonata\CoreBundle\DependencyInjection\Compiler\ExporterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ExporterCompilerPassTest extends AbstractCompilerPassTestCase
{
    public function testWritersAreAddedToTheExporter()
    {
        $exporter = new Definition();
        $this->setDefinition('sonata.core.exporter', $exporter);

        $writer = new Definition();
        $writer->addTag('sonata.core.exporter.writer');
        $this->setDefinition('foo_writer', $writer);

        $this->compile();
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'sonata.core.exporter',
            'addWriter',
            array(
                new Reference('foo_writer'),
            )
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExporterCompilerPass());
    }
}
