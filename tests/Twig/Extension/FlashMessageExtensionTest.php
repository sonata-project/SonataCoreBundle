<?php
namespace Sonata\CoreBundle\Tests\Twig\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\FlashMessage\FlashManager;
use Sonata\CoreBundle\Twig\Extension\FlashMessageExtension;

class FlashMessageExtensionTest extends TestCase
{
    private $extension;

    protected function setUp()
    {
        $this->extension = new FlashMessageExtension(
            $this->prophesize(FlashManager::class)->reveal()
        );
    }

    public function testFunctionsArePrefixed()
    {
        foreach ($this->extension->getFunctions() as $function) {
            $this->assertTrue(
                0 === strpos($function->getName(), 'sonata_flashmessages_'),
                'All function names should start with a standard prefix'
            );
        }
    }
}
