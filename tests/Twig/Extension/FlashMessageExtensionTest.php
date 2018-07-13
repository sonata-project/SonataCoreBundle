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
use Sonata\CoreBundle\Twig\Extension\FlashMessageExtension;

class FlashMessageExtensionTest extends TestCase
{
    private $extension;

    protected function setUp(): void
    {
        $this->extension = new FlashMessageExtension();
    }

    public function testFunctionsArePrefixed(): void
    {
        foreach ($this->extension->getFunctions() as $function) {
            $this->assertTrue(
                0 === strpos($function->getName(), 'sonata_flashmessages_'),
                'All function names should start with a standard prefix'
            );
        }
    }
}
