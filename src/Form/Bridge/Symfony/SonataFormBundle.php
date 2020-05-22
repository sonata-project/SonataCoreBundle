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

namespace Sonata\Form\Bridge\Symfony;

use Sonata\Form\Bridge\Symfony\DependencyInjection\SonataFormExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SonataFormBundle extends Bundle
{
    protected function getContainerExtensionClass()
    {
        return SonataFormExtension::class;
    }
}
