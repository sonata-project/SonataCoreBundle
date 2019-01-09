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
use Sonata\CoreBundle\Component\Status\StatusClassRendererInterface;
use Sonata\CoreBundle\Twig\Extension\StatusExtension;

class StatusExtensionTest extends TestCase
{
    public function testGetName()
    {
        $extension = new StatusExtension();
        $this->assertSame('sonata_core_status', $extension->getName());
    }

    public function testGetFilters()
    {
        $extension = new StatusExtension();
        $filters = $extension->getFilters();

        $this->assertContainsOnlyInstancesOf('Twig_SimpleFilter', $filters);
    }

    /**
     * @group legacy
     */
    public function testStatusClassDefaultValue()
    {
        $extension = new StatusExtension();
        $statusService = $this->getMockBuilder(StatusClassRendererInterface::class)
            ->getMock();
        $statusService->expects($this->once())
            ->method('handlesObject')
            ->will($this->returnValue(false));

        $extension->addStatusService($statusService);
        $this->assertSame('test-value', $extension->statusClass(new \stdClass(), 'getStatus', 'test-value'));
    }
}
