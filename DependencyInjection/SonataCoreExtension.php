<?php
/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * SonataCoreExtension
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class SonataCoreExtension extends Extension
{
    /**
     * Loads the url shortener configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('flash.xml');
        $loader->load('form_types.xml');
        $loader->load('twig.xml');

        $this->registerFlashTypes($container, $config);

        $this->configureClassesToCompile();
    }
    
    public function configureClassesToCompile()
    {
        $this->addClassesToCompile(array(
            "Sonata\\CoreBundle\\Form\\Type\\BooleanType",
            "Sonata\\CoreBundle\\Form\\Type\\CollectionType",
            "Sonata\\CoreBundle\\Form\\Type\\DateRangeType",
            "Sonata\\CoreBundle\\Form\\Type\\DateTimeRangeType",
            "Sonata\\CoreBundle\\Form\\Type\\EqualType",
            "Sonata\\CoreBundle\\Form\\Type\\ImmutableArrayType",
            "Sonata\\CoreBundle\\Form\\Type\\TranslatableChoiceType",
        ));
    }

    /**
     * Registers flash message types defined in configuration to flash manager
     *
     * @param  \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param  array                                                   $config
     *
     * @return void
     */
    public function registerFlashTypes(ContainerBuilder $container, array $config)
    {
        $types = array(
            'success' => array(
                array_merge($config['flashmessage']['success'], array(
                    'sonata_flash_success',
                    'sonata_user_success',
                    'fos_user_success'
                ))
            ),
            'warning' => array(
                array_merge($config['flashmessage']['warning'], array(
                    'sonata_flash_info'
                ))
            ),
            'error' => array(
                array_merge($config['flashmessage']['error'], array(
                    'sonata_flash_error',
                    'sonata_user_error'
                ))
            ),
        );

        $identifier = 'sonata.core.flashmessage.manager';

        $definition = $container->getDefinition($identifier);
        $definition->replaceArgument(1, $types);

        $container->setDefinition($identifier, $definition);
    }
}
