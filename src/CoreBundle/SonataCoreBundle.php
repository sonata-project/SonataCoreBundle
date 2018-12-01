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

namespace Sonata\CoreBundle;

use Sonata\CoreBundle\DependencyInjection\Compiler\AdapterCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SonataCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AdapterCompilerPass());
        $container->addCompilerPass(new StatusRendererCompilerPass());
    }
}
