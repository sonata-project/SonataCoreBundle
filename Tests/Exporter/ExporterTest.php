<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Exporter;

use Exporter\Source\ArraySourceIterator;
use Exporter\Writer\CsvWriter;
use Exporter\Writer\JsonWriter;
use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use Sonata\CoreBundle\Exporter\Exporter;

class ExporterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $this->setExpectedException('RuntimeException', 'Invalid "foo" format');
        $source = $this->getMock('Exporter\Source\SourceIteratorInterface');
        $writer = $this->getMock('Exporter\Writer\TypedWriterInterface');

        $exporter = new Exporter(array($writer));
        $exporter->getResponse('foo', 'foo', $source);
    }

    public function testConstructorRejectsNonTypedWriters()
    {
        $this->setExpectedException(
            version_compare(PHP_VERSION, '7.0.0', '<') ? 'PHPUnit_Framework_Error' : 'TypeError',
            'must implement interface'
        );
        new Exporter(array('Not even an object'));
    }

    /**
     * NEXT_MAJOR: remove this test.
     *
     * @dataProvider getResponseLegacyTests
     * @group legacy
     */
    public function testConstructorCreatesDefaultWritersOnLegacyCall($format, $filename, $contentType)
    {
        $source = new ArraySourceIterator(array(
            array('foo' => 'bar'),
        ));

        $exporter = new Exporter();
        $response = $exporter->getResponse($format, $filename, $source);

        $this->assertSame($contentType, $response->headers->get('Content-Type'));
    }

    /**
     * NEXT_MAJOR: remove this method.
     */
    public function getResponseLegacyTests()
    {
        return array(
            array('json', 'foo.json', 'application/json'),
            array('xml', 'foo.xml', 'text/xml'),
            array('xls', 'foo.xls', 'application/vnd.ms-excel'),
            array('csv', 'foo.csv', 'text/csv'),
        );
    }

    /**
     * @dataProvider getGetResponseTests
     */
    public function testGetResponse($format, $filename, $contentType)
    {
        $source = new ArraySourceIterator(array(
            array('foo' => 'bar'),
        ));
        $writer = $this->getMock('Exporter\Writer\TypedWriterInterface');
        $writer->expects($this->any())
            ->method('getFormat')
            ->willReturn('made-up');
        $writer->expects($this->any())
            ->method('getDefaultMimeType')
            ->willReturn('application/made-up');

        $exporter = new Exporter(array(
            'csv' => new CsvWriter('php://output', ',', '"', '', true, true),
            'json' => new JsonWriter('php://output'),
            'xls' => new XlsWriter('php://output'),
            'xml' => new XmlWriter('php://output'),
            'made-up' => $writer,
        ));
        $response = $exporter->getResponse($format, $filename, $source);

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
        $this->assertSame($contentType, $response->headers->get('Content-Type'));
        $this->assertSame('attachment; filename="'.$filename.'"', $response->headers->get('Content-Disposition'));
    }

    public function getGetResponseTests()
    {
        return array(
            array('json', 'foo.json', 'application/json'),
            array('xml', 'foo.xml', 'text/xml'),
            array('xls', 'foo.xls', 'application/vnd.ms-excel'),
            array('csv', 'foo.csv', 'text/csv'),
            array('made-up', 'foo.made-up', 'application/made-up'),
        );
    }
}
