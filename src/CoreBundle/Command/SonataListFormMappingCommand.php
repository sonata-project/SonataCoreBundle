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

namespace Sonata\CoreBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @deprecated since sonata-project/core-bundle 3.7, to be removed in 4.0, the form mapping feature should be disabled.
 */
class SonataListFormMappingCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $metadata;

    public function __construct(ContainerInterface $container, string $name = null)
    {
        parent::__construct($name);

        $this->container = $container;
    }

    public function isEnabled()
    {
        return Kernel::MAJOR_VERSION < 3;
    }

    protected function configure()
    {
        $this
            ->setName('sonata:core:form-mapping')
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'Output the mapping into a dedicated format (available: yaml, php)',
                'yaml'
            )
            ->setDescription('Get information on the current form mapping')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Getting form types:');
        foreach ($this->container->getParameter('sonata.core.form.types') as $id) {
            try {
                $instance = $this->container->get($id);

                if ('yaml' === $input->getOption('format')) {
                    $output->writeln(sprintf('              %s: %s', $instance->getName(), \get_class($instance)));
                } else {
                    $output->writeln(sprintf(" '%s' => '%s',", $instance->getName(), \get_class($instance)));
                }
            } catch (\Exception $e) {
                $output->writeln(sprintf('<error>Unable load service: %s</error>', $id));
            }
        }

        $output->writeln("\n\n\nGetting form type extensions:");
        $types = [];
        foreach ($this->container->getParameter('sonata.core.form.type_extensions') as $id) {
            try {
                $instance = $this->container->get($id);
                if (!isset($types[$instance->getExtendedType()])) {
                    $types[$instance->getExtendedType()] = [];
                }

                $types[$instance->getExtendedType()][] = $id;
            } catch (\Exception $e) {
                $output->writeln(sprintf('<error>Unable load service: %s</error>', $id));
            }
        }

        foreach ($types as $type => $classes) {
            if ('yaml' === $input->getOption('format')) {
                $output->writeln(sprintf('        %s: ', $type));
            } else {
                $output->writeln(sprintf("        '%s' => array( ", $type));
            }

            foreach ($classes as $class) {
                if ('yaml' === $input->getOption('format')) {
                    $output->writeln(sprintf('              - %s', $class));
                } else {
                    $output->writeln(sprintf("              '%s',", $class));
                }
            }

            if ('php' === $input->getOption('format')) {
                $output->writeln('        ), ');
            }
        }

        return 0;
    }
}
