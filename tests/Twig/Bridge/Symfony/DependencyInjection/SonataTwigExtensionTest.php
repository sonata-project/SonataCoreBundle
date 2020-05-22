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

namespace Sonata\Twig\Tests\Bridge\Symfony\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Sonata\Twig\Bridge\Symfony\DependencyInjection\SonataTwigExtension;

final class SonataTwigExtensionTest extends AbstractExtensionTestCase
{
    public function testHasFormTypeParameter(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('sonata.twig.form_type', 'standard');
    }

    protected function getContainerExtensions(): array
    {
        return [
            new SonataTwigExtension(),
        ];
    }
}
