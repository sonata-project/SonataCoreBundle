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

use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\RuntimeLoaderPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * NEXT_MAJOR : remove this class when dropping support for Symfony 2.8.
 *
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class FlashMessageCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!class_exists(RuntimeLoaderPass::class) && $container->hasDefinition('sonata.core.flashmessage.twig.extension')) {
            $container->getDefinition('sonata.core.flashmessage.twig.extension')
                ->setArguments([new Reference('sonata.core.flashmessage.manager')]);
        }
    }
}
