<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Grégoire Paris <postmaster@greg0ire.fr>
 */
final class ExporterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('sonata.core.exporter')) {
            return;
        }

        $definition = $container->findDefinition('sonata.core.exporter');
        $writers = $container->findTaggedServiceIds('sonata.core.exporter.writer');

        foreach (array_keys($writers) as $id) {
            $definition->addMethodCall(
                'addWriter',
                array(new Reference($id))
            );
        }
    }
}
