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
use Sonata\CoreBundle\DependencyInjection\Compiler\FlashMessageCompilerPass;
use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\RuntimeLoaderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @group legacy
 */
final class FlashMessageCompilerPassTest extends AbstractCompilerPassTestCase
{
    public function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FlashMessageCompilerPass());
    }

    public function testProcess()
    {
        $this->setDefinition('sonata.core.flashmessage.twig.extension', new Definition());

        $this->compile();

        $definition = $this->container->getDefinition('sonata.core.flashmessage.twig.extension');
        if (!class_exists(RuntimeLoaderPass::class)) {
            $this->assertCount(1, $definition->getArguments());
        } else {
            $this->assertCount(0, $definition->getArguments());
        }
    }
}
