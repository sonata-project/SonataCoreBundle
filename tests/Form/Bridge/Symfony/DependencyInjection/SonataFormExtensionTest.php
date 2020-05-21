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

namespace Sonata\Form\Tests\Bridge\Symfony\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\Form\Bridge\Symfony\DependencyInjection\SonataFormExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SonataFormExtensionTest extends AbstractExtensionTestCase
{
    public function testAfterLoadingTheWrappingParameterIsSet(): void
    {
        $this->container->setParameter('kernel.bundles', []);
        $this->load();
        $this->assertContainerBuilderHasParameter(
            'sonata.form.form_type'
        );
        $this->assertSame(
            'standard',
            $this->container->getParameter(
                'sonata.form.form_type'
            )
        );
    }

    public function testHorizontalFormTypeMeansNoWrapping(): void
    {
        $this->container->setParameter('kernel.bundles', []);
        $this->load([
            'form_type' => 'horizontal',
        ]);
        $this->assertContainerBuilderHasParameter(
            'sonata.form.form_type'
        );
        $this->assertSame(
            'horizontal',
            $this->container->getParameter(
                'sonata.form.form_type'
            )
        );
    }

    public function testPrepend(): void
    {
        $containerBuilder = $this->prophesize(ContainerBuilder::class);

        $containerBuilder->getExtensionConfig('sonata_admin')->willReturn([
            ['some_key_we_do_not_care_about' => 42],
            ['options' => ['form_type' => 'standard']],
            ['options' => ['form_type' => 'horizontal']],
        ]);

        $containerBuilder->prependExtensionConfig(
            'sonata_form',
            ['form_type' => 'standard']
        )->shouldBeCalled();

        $containerBuilder->prependExtensionConfig(
            'sonata_form',
            ['form_type' => 'horizontal']
        )->shouldBeCalled();

        $extension = new SonataFormExtension();
        $extension->prepend($containerBuilder->reveal());
    }

    protected function getContainerExtensions(): array
    {
        return [
            new SonataFormExtension(),
        ];
    }
}
