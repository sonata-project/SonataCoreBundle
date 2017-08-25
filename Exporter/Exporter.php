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
use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;

@trigger_error(
    'The '.__NAMESPACE__.'\Exporter class is deprecated since version 3.1 and will be removed in 4.0.'.
    ' Use Exporter\Exporter instead',
    E_USER_DEPRECATED
);

/**
 * NEXT_MAJOR: remove this class, and the dev dependency.
 */
class Exporter
{
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
        switch ($format) {
            case 'xls':
                $writer = new XlsWriter('php://output');
                $contentType = 'application/vnd.ms-excel';

                break;
            case 'xml':
                $writer = new XmlWriter('php://output');
                $contentType = 'text/xml';

                break;
            case 'json':
                $writer = new JsonWriter('php://output');
                $contentType = 'application/json';

                break;
            case 'csv':
                $writer = new CsvWriter('php://output', ',', '"', '', true, true);
                $contentType = 'text/csv';

                break;
            default:
                throw new \RuntimeException('Invalid format');
        }

        $callback = function () use ($source, $writer) {
            $handler = \Exporter\Handler::create($source, $writer);
            $handler->export();
        };

        return new StreamedResponse($callback, 200, array(
            'Content-Type' => $contentType,
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
        ));
    }
}
