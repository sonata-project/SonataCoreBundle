<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Exporter;

use Exporter\Source\SourceIteratorInterface;
use Exporter\Writer\CsvWriter;
use Exporter\Writer\JsonWriter;
use Exporter\Writer\TypedWriterInterface;
use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Exporter
{
    /**
     * @var TypedWriterInterface[]
     */
    private $writers;

    /**
     * NEXT_MAJOR: change default value to array().
     *
     * @param TypedWriterInterface[] $writers an array of allowed typed writers, indexed by format name
     */
    public function __construct(array $writers = null)
    {
        $this->writers = array();
        // NEXT_MAJOR: remove this fallback system
        if ($writers === null) {
            @trigger_error(
                'Not supplying writers to the Exporter is deprecated and will not be supported in 4.0.',
                E_USER_DEPRECATED
            );

            $this->addWriter(new CsvWriter('php://output', ',', '"', '', true, true));
            $this->addWriter(new JsonWriter('php://output'));
            $this->addWriter(new XlsWriter('php://output'));
            $this->addWriter(new XmlWriter('php://output'));

            return;
        }

        foreach ($writers as $writer) {
            $this->addWriter($writer);
        }
    }

    /**
     * @throws \RuntimeException
     *
     * @param string                  $format
     * @param string                  $filename
     * @param SourceIteratorInterface $source
     *
     * @return StreamedResponse
     */
    public function getResponse($format, $filename, SourceIteratorInterface $source)
    {
        if (!array_key_exists($format, $this->writers)) {
            throw new \RuntimeException(sprintf(
                'Invalid "%s" format, supported formats are : "%s"',
                $format,
                implode(', ', array_keys($this->writers))
            ));
        }
        $writer = $this->writers[$format];

        $callback = function () use ($source, $writer) {
            $handler = \Exporter\Handler::create($source, $writer);
            $handler->export();
        };

        $headers = array(
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
        );

        $headers['Content-Type'] = $writer->getDefaultMimeType();

        return new StreamedResponse($callback, 200, $headers);
    }

    /**
     * The main benefit of this method is the type hinting.
     *
     * @param TypedWriterInterface $writer a possible writer for exporting data
     */
    private function addWriter(TypedWriterInterface $writer)
    {
        $this->writers[$writer->getFormat()] = $writer;
    }
}
