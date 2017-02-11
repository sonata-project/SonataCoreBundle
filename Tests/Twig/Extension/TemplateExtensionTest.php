<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Twig\Extension;

use Sonata\CoreBundle\Tests\PHPUnit_Framework_TestCase;
use Sonata\CoreBundle\Twig\Extension\TemplateExtension;

class TemplateExtensionTest extends PHPUnit_Framework_TestCase
{
    public function testSafeUrl()
    {
        $translator = $this->createMock('Symfony\Component\Translation\TranslatorInterface');

        $adapter = $this->createMock('Sonata\CoreBundle\Model\Adapter\AdapterInterface');
        $adapter->expects($this->once())->method('getUrlsafeIdentifier')->will($this->returnValue('safe-parameter'));

        $extension = new TemplateExtension(true, $translator, $adapter);

        $this->assertSame('safe-parameter', $extension->getUrlsafeIdentifier(new \stdClass()));
    }
}
