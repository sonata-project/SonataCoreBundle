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

namespace Sonata\CoreBundle\Tests\Model\Adapter;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Model\Adapter\AdapterChain;
use Sonata\CoreBundle\Model\Adapter\AdapterInterface;

class AdapterChainTest extends TestCase
{
    public function testEmptyAdapter(): void
    {
        $adapter = new AdapterChain();

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
        $this->assertNull($adapter->getUrlsafeIdentifier(new \stdClass()));
    }

    public function testUrlSafeIdentifier(): void
    {
        $adapter = new AdapterChain();

        $adapter->addAdapter($fake1 = $this->createMock(AdapterInterface::class));
        $fake1->expects($this->once())->method('getUrlsafeIdentifier')->will($this->returnValue(null));

        $adapter->addAdapter($fake2 = $this->createMock(AdapterInterface::class));

        $fake2->expects($this->once())->method('getUrlsafeIdentifier')->will($this->returnValue('voila'));

        $this->assertSame('voila', $adapter->getUrlsafeIdentifier(new \stdClass()));
    }

    public function testNormalizedIdentifier(): void
    {
        $adapter = new AdapterChain();

        $adapter->addAdapter($fake1 = $this->createMock(AdapterInterface::class));
        $fake1->expects($this->once())->method('getNormalizedIdentifier')->will($this->returnValue(null));

        $adapter->addAdapter($fake2 = $this->createMock(AdapterInterface::class));

        $fake2->expects($this->once())->method('getNormalizedIdentifier')->will($this->returnValue('voila'));

        $this->assertSame('voila', $adapter->getNormalizedIdentifier(new \stdClass()));
    }
}
