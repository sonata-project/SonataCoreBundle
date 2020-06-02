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
final class FormCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $this->registerDateAliases($container);
        $this->registerFormTypeAlias($container);
        $this->forceUserToMoveConfig($container);
    }

    private function registerDateAliases(ContainerBuilder $container)
    {
        $container
            ->setAlias('sonata.core.date.moment_format_converter', 'sonata.form.date.moment_format_converter')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.date.moment_format_converter" instead.'
            );
    }

    private function registerFormTypeAlias(ContainerBuilder $container)
    {
        $container
            ->setAlias('sonata.core.form.type.array', 'sonata.form.type.array')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.array" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.boolean', 'sonata.form.type.boolean')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.boolean" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.collection', 'sonata.form.type.collection')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.collection" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.date_range', 'sonata.form.type.date_range')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.date_range" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.datetime_range', 'sonata.form.type.datetime_range')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.datetime_range" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.date_picker', 'sonata.form.type.date_picker')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.date_picker" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.datetime_picker', 'sonata.form.type.datetime_picker')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.datetime_picker" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.date_range_picker', 'sonata.form.type.date_range_picker')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.date_range_picker" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.datetime_range_picker', 'sonata.form.type.datetime_range_picker')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.datetime_range_picker" instead.'
            );

        $container
            ->setAlias('sonata.core.form.type.equal', 'sonata.form.type.equal')
            ->setPublic(true)
            ->setDeprecated(
                true,
                'The "%alias_id%" service is deprecated since sonata-project/core-bundle 3.19 and will be removed in 4.0. Use "sonata.form.type.equal" instead.'
            );
    }

    private function forceUserToMoveConfig(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['SonataFormBundle'])) {
            return;
        }

        $defaultSerializer = [
                'formats' => [
                    0 => 'json',
                    1 => 'xml',
                    2 => 'yml',
                ],
            ];

        if ($container->getParameter('sonata.core.serializer') !== $defaultSerializer) {
            throw new \Exception('You are register SonataFormBundle (sonata-project/form-extensions bridge). For now '.
                'SonataCoreBundle will be use sonata_form configuration. Keep sonata_core.serializer section clear and use sonata_form.serializer instead.');
        }
    }
}
