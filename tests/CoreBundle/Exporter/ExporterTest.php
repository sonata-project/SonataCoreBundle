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

namespace Sonata\CoreBundle\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Exporter\Exporter;
use Sonata\Exporter\Source\ArraySourceIterator;
use Sonata\Exporter\Source\SourceIteratorInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * NEXT_MAJOR: remove this class.
 *
 * @group legacy
 */
class ExporterTest extends TestCase
{
    public function testFilter()
    {
        $this->expectException(\RuntimeException::class);

        $source = $this->createMock(SourceIteratorInterface::class);

        $exporter = new Exporter();
        $exporter->getResponse('foo', 'foo', $source);
    }

    /**
     * @dataProvider getGetResponseTests
     */
    public function testGetResponse($format, $filename, $contentType)
    {
        $source = new ArraySourceIterator([
            ['foo' => 'bar'],
        ]);

        $exporter = new Exporter();
        $response = $exporter->getResponse($format, $filename, $source);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame($contentType, $response->headers->get('Content-Type'));
        $this->assertSame('attachment; filename="'.$filename.'"', $response->headers->get('Content-Disposition'));
    }

    public function getGetResponseTests()
    {
        return [
            ['json', 'foo.json', 'application/json'],
            ['xml', 'foo.xml', 'text/xml'],
            ['xls', 'foo.xls', 'application/vnd.ms-excel'],
            ['csv', 'foo.csv', 'text/csv'],
        ];
    }
}
