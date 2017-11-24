<?php
namespace Sonata\CoreBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Twig\Extension\DeprecatedTextExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class DeprecatedTextExtensionTest extends TestCase
{
    /**
     * @group legacy
     * @expectedDeprecation Using the sonata.core.twig.extension.text service is deprecated since 3.2 and will be removed in 4.0
     */
    public function testDeprecation()
    {
        $extension = new DeprecatedTextExtension();
        $extension->twig_truncate_filter(
            new Environment(new ArrayLoader()),
            'A long piece of text, well not that long actually but whatever.'
        );
    }
}
