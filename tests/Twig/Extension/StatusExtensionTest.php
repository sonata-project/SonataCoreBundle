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

namespace Sonata\Twig\Tests\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\Twig\Extension\StatusExtension;
use Twig\TwigFilter;

class StatusExtensionTest extends TestCase
{
    public function testGetName(): void
    {
        $extension = new StatusExtension();
        $this->assertSame('sonata_twig_status', $extension->getName());
    }

    public function testGetFilters(): void
    {
        $extension = new StatusExtension();
        $filters = $extension->getFilters();

        $this->assertContainsOnlyInstancesOf(TwigFilter::class, $filters);
    }
}
