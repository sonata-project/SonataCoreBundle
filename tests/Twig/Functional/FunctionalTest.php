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

namespace Sonata\Twig\Tests\Functional;

use Sonata\Twig\Tests\App\AppKernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class FunctionalTest extends WebTestCase
{
    public function testRenderFlashes(): void
    {
        $kernel = new AppKernel();

        $client = $this->createClientBC($kernel);
        $client->request('GET', '/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }

    private function createClientBC(KernelInterface $kernel)
    {
        if (class_exists(KernelBrowser::class)) {
            return new KernelBrowser($kernel);
        }

        return static::createClient();
    }
}
