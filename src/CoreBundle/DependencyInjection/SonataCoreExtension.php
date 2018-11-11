<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\DependencyInjection;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DateRangeType;
use Sonata\CoreBundle\Form\Type\DateTimeRangeType;
use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Form\Type\TranslatableChoiceType;
use Sonata\CoreBundle\Serializer\BaseSerializerHandler;
use Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\FormPass;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SonataCoreExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('sonata_admin');

        foreach ($configs as $config) {
            if (isset($config['options']['form_type'])) {
                $container->prependExtensionConfig(
                    $this->getAlias(),
                    ['form_type' => $config['options']['form_type']]
                );
            }
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        // NEXT_MAJOR : remove this if block
        if (!interface_exists(SubscribingHandlerInterface::class)) {
            /* Let's check for config values before the configuration is processed,
             * otherwise we won't be able to tell,
             * since there is a default value for this option. */
            foreach ($configs as $config) {
                if (isset($config['serializer'])) {
                    @trigger_error(<<<'EOT'
Setting the sonata_core -> serializer -> formats option
without having the jms/serializer library installed is deprecated since 3.1,
and will not be supported in 4.0,
because the configuration option will not be added in that case.
EOT
                    , E_USER_DEPRECATED);
                }
            }
        }
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('date.xml');
        $loader->load('flash.xml');
        $loader->load('form_types.xml');
        $loader->load('validator.xml');
        $loader->load('twig.xml');
        $loader->load('model_adapter.xml');
        $loader->load('core.xml');
        $loader->load('commands.xml');

        $this->registerFlashTypes($container, $config);
        $container->setParameter('sonata.core.form_type', $config['form_type']);

        $this->configureFormFactory($container, $config);
        if (\PHP_VERSION_ID < 70000) {
            $this->configureClassesToCompile();
        }

        $this->deprecateSlugify($container);

        $this->configureSerializerFormats($config);
    }

    public function configureClassesToCompile()
    {
        $this->addClassesToCompile([
            BooleanType::class,
            CollectionType::class,
            DateRangeType::class,
            DateTimeRangeType::class,
            EqualType::class,
            ImmutableArrayType::class,
            TranslatableChoiceType::class,
        ]);
    }

    public function configureFormFactory(ContainerBuilder $container, array $config)
    {
        if (!$config['form']['mapping']['enabled'] || !class_exists(FormPass::class)) {
            $container->removeDefinition('sonata.core.form.extension.dependency');

            return;
        }

        @trigger_error(
            'Relying on the form mapping feature is deprecated since 3.7 and will be removed in 4.0. Please set the "sonata_core.form.mapping.enabled" configuration node to false to avoid this message.',
            E_USER_DEPRECATED
        );

        $container->setParameter('sonata.core.form.mapping.type', $config['form']['mapping']['type']);
        $container->setParameter('sonata.core.form.mapping.extension', $config['form']['mapping']['extension']);

        FormHelper::registerFormTypeMapping($config['form']['mapping']['type']);
        foreach ($config['form']['mapping']['extension'] as $ext => $idx) {
            FormHelper::registerFormExtensionMapping($ext, $idx);
        }

        $definition = $container->getDefinition('sonata.core.form.extension.dependency');
        $definition->replaceArgument(4, FormHelper::getFormTypeMapping());

        $definition = $container->getDefinition('sonata.core.form.extension.dependency');
        $definition->replaceArgument(5, FormHelper::getFormExtensionMapping());
    }

    /**
     * Registers flash message types defined in configuration to flash manager.
     */
    public function registerFlashTypes(ContainerBuilder $container, array $config)
    {
        $mergedConfig = array_merge_recursive($config['flashmessage'], [
            'success' => ['types' => [
                'success' => ['domain' => 'SonataCoreBundle'],
                'sonata_flash_success' => ['domain' => 'SonataAdminBundle'],
                'sonata_user_success' => ['domain' => 'SonataUserBundle'],
                'fos_user_success' => ['domain' => 'FOSUserBundle'],
            ]],
            'warning' => ['types' => [
                'warning' => ['domain' => 'SonataCoreBundle'],
                'sonata_flash_info' => ['domain' => 'SonataAdminBundle'],
            ]],
            'danger' => ['types' => [
                'error' => ['domain' => 'SonataCoreBundle'],
                'sonata_flash_error' => ['domain' => 'SonataAdminBundle'],
                'sonata_user_error' => ['domain' => 'SonataUserBundle'],
            ]],
        ]);

        $types = $cssClasses = [];

        foreach ($mergedConfig as $typeKey => $typeConfig) {
            $types[$typeKey] = $typeConfig['types'];
            $cssClasses[$typeKey] = array_key_exists('css_class', $typeConfig) ? $typeConfig['css_class'] : $typeKey;
        }

        $identifier = 'sonata.core.flashmessage.manager';

        $definition = $container->getDefinition($identifier);
        $definition->replaceArgument(2, $types);
        $definition->replaceArgument(3, $cssClasses);

        $container->setDefinition($identifier, $definition);
    }

    /**
     * @param array $config
     */
    public function configureSerializerFormats($config)
    {
        if (interface_exists(SubscribingHandlerInterface::class)) {
            BaseSerializerHandler::setFormats($config['serializer']['formats']);
        }
    }

    protected function deprecateSlugify(ContainerBuilder $container)
    {
        $container->getDefinition('sonata.core.slugify.cocur')->setDeprecated(true);
        $container->getDefinition('sonata.core.slugify.native')->setDeprecated(true);
    }
}
