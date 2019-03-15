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
use Sonata\Doctrine\Adapter\AdapterInterface;
use Sonata\Twig\Extension\TemplateExtension;

class TemplateExtensionTest extends TestCase
{
    public function testSafeUrl(): void
    {
        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects($this->once())->method('getUrlsafeIdentifier')->will($this->returnValue('safe-parameter'));

        $extension = new TemplateExtension(true, $adapter);

        $this->assertSame('safe-parameter', $extension->getUrlsafeIdentifier(new \stdClass()));
    }
}
