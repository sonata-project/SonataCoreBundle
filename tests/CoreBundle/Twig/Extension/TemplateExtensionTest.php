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
use Sonata\CoreBundle\Model\Adapter\AdapterInterface;
use Sonata\Twig\Extension\TemplateExtension;
use Symfony\Component\Translation\TranslatorInterface;

class TemplateExtensionTest extends TestCase
{
    /**
     * @group legacy
     */
    public function testSlugify()
    {
        setlocale(LC_ALL, 'en_US.utf8');
        setlocale(LC_CTYPE, 'en_US.utf8');

        $translator = $this->createMock(TranslatorInterface::class);

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects($this->never())->method('getUrlsafeIdentifier');

        $extension = new TemplateExtension(true, $translator, $adapter);

        $this->assertSame($extension->slugify('test'), 'test');
        $this->assertSame($extension->slugify('S§!@@#$#$alut'), 's-alut');
        $this->assertSame($extension->slugify('Symfony2'), 'symfony2');
        $this->assertSame($extension->slugify('test'), 'test');
        $this->assertSame($extension->slugify('c\'est bientôt l\'été'), 'c-est-bientot-l-ete');
        $this->assertSame($extension->slugify(urldecode('%2Fc\'est+bientôt+l\'été')), 'c-est-bientot-l-ete');
    }

    public function testSafeUrl()
    {
        $translator = $this->createMock(TranslatorInterface::class);

        $adapter = $this->createMock(AdapterInterface::class);
        $adapter->expects($this->once())->method('getUrlsafeIdentifier')->will($this->returnValue('safe-parameter'));

        $extension = new TemplateExtension(true, $translator, $adapter);

        $this->assertSame('safe-parameter', $extension->getUrlsafeIdentifier(new \stdClass()));
    }
}
