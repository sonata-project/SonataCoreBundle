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

namespace Sonata\CoreBundle\Tests;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\DependencyInjection\Compiler\AdapterCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Sonata\CoreBundle\SonataCoreBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class SonataCoreBundleTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testBuild(): void
    {
        $containerBuilder = $this->createMock(ContainerBuilder::class);

        $containerBuilder->expects($this->any())
            ->method('addCompilerPass')
            ->will($this->returnCallback(function (CompilerPassInterface $pass): void {
                if ($pass instanceof StatusRendererCompilerPass) {
                    return;
                }

                if ($pass instanceof AdapterCompilerPass) {
                    return;
                }

                $this->fail(sprintf(
                    'Compiler pass is not one of the expected types.
                    Expects "Sonata\AdminBundle\DependencyInjection\Compiler\StatusRendererCompilerPass" or
                    "Sonata\AdminBundle\DependencyInjection\Compiler\AdapterCompilerPass", but got "%s".',
                    \get_class($pass)
                ));
            }));

        $bundle = new SonataCoreBundle();
        $bundle->build($containerBuilder);
    }
}
