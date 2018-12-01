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

namespace Sonata\CoreBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Twig\Extension\StatusExtension;

class StatusExtensionTest extends TestCase
{
    public function testGetName(): void
    {
        $extension = new StatusExtension();
        $this->assertSame('sonata_core_status', $extension->getName());
    }

    public function testGetFilters(): void
    {
        $extension = new StatusExtension();
        $filters = $extension->getFilters();

        $this->assertContainsOnlyInstancesOf('Twig_SimpleFilter', $filters);
    }
}
