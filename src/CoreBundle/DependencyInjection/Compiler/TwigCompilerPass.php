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

namespace Sonata\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * @deprecated since sonata-project/core-bundle 3.19, to be removed in 4.0.
 */
final class TwigCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->registerFlashAliases($container);
        $this->registerTwigAliases($container);
        $this->forceUserToMoveConfig($container);
    }

    private function registerFlashAliases(ContainerBuilder $container)
    {
        $container
            ->setAlias('sonata.core.flashmessage.manager', 'sonata.twig.flashmessage.manager')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.flashmessage.manager" instead.'
            );

        $container
            ->setAlias('sonata.core.flashmessage.twig.runtime', 'sonata.twig.flashmessage.twig.runtime')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.flashmessage.twig.runtime" instead.'
            );

        $container
            ->setAlias('sonata.core.flashmessage.twig.extension', 'sonata.twig.flashmessage.twig.extension')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.flashmessage.twig.extension" instead.'
            );
    }

    private function registerTwigAliases(ContainerBuilder $container)
    {
        $container
            ->setAlias('sonata.core.twig.extension.wrapping', 'sonata.twig.extension.wrapping')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.extension.wrapping" instead.'
            );

        $container
            ->setAlias('sonata.core.twig.status_runtime', 'sonata.twig.status_runtime')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.status_runtime" instead.'
            );

        $container
            ->setAlias('sonata.core.twig.deprecated_template_extension', 'sonata.twig.deprecated_template_extension')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.deprecated_template_extension" instead.'
            );

        $container
            ->setAlias('sonata.core.twig.template_extension', 'sonata.twig.template_extension')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.twig.template_extension" instead.'
            );
    }

    private function forceUserToMoveConfig(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['SonataTwigBundle'])) {
            return;
        }

        if (!empty($container->getParameter('sonata.core.flashmessage'))) {
            throw new \Exception('You are register SonataTwigBundle (sonata-project/twig-extensions bridge). '.
                'For now SonataCoreBundle will be use sonata_twig configuration. '.
                'Keep sonata_core.flashmessage section clear and use sonata_form.flashmessage instead.');
        }
    }
}
