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

namespace Sonata\Twig\Tests\Bridge\Symfony\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Sonata\Twig\Bridge\Symfony\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class StatusRendererCompilerPassTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new StatusRendererCompilerPass());
    }

    public function testProcess(): void
    {
        $statusRenderer = new Definition();
        $statusRenderer->addTag('sonata.status.renderer');
        $this->setDefinition('sonata.status.renderer', $statusRenderer);

        $statusExtension = new Definition();
        $this->setDefinition('sonata.twig.status_extension', $statusExtension);
        $this->setDefinition('sonata.twig.status_runtime', $statusExtension);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'sonata.twig.status_runtime',
            'addStatusService',
            [new Reference('sonata.status.renderer')]
        );
    }
}
