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

use Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @deprecated since 3.7, to be removed in 4.0, the form mapping feature should be disabled.
 */
class FormFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $typeIdx = [];
        foreach ($container->findTaggedServiceIds('form.type') as $id => $tags) {
            $typeIdx[] = $id;
        }

        $typeExtensionIdx = [];
        foreach ($container->findTaggedServiceIds('form.type_extension') as $id => $tag) {
            $typeExtensionIdx[] = $id;
        }

        $container->setParameter('sonata.core.form.types', $typeIdx);
        $container->setParameter('sonata.core.form.type_extensions', $typeExtensionIdx);

        // nothing to do
        if (!$container->hasDefinition('sonata.core.form.extension.dependency')) {
            return;
        }

        // get factories
        $original = $container->getDefinition('form.extension');
        $this->processFormPass($container);

        $factory = $container->getDefinition('sonata.core.form.extension.dependency');
        $factory->replaceArgument(1, $original->getArgument(1));
        $factory->replaceArgument(2, $original->getArgument(2));
        $factory->replaceArgument(3, $original->getArgument(3));

        $container->removeDefinition('form.extension');
        $container->removeDefinition('sonata.core.form.extension.dependency');

        $container->setDefinition('form.extension', $factory);
    }

    private function processFormPass(ContainerBuilder $container)
    {
        $formPass = new FormPass();
        $formPass->process($container);
    }
}
