The exporter
============

This bundle provides a ``sonata.core.exporter`` service that integrates ``sonata-project/exporter`` with Symfony
by building a streamed response directly usable in a Symfony controller from a format, a filename, and a source.

.. code-block:: php

    <?php
    namespace MyCompany\MyProject\Controller;

    class WhateverController
    {
        public function myExportAction()
        {
            // build $source, which must be an Exporter\Source\SourceIteratorInterface implementation
            return $this->get('sonata.core.exporter')->getResponse(
                'csv', // possible values are csv, json, xls, and xml
                '/tmp/myFile.csv',
                $source
            );
        }
    }

The default writers
-------------------

Under the hood, the exporter one service for each available format.
Each service has its own parameters, documented below.

The CSV writer service
~~~~~~~~~~~~~~~~~~~~~~
This service can be configured throught the following parameters:

* ``sonata.core.exporter.writer.csv.filename``: defaults to ``php://output``
* ``sonata.core.exporter.writer.csv.delimiter``: defaults to ``,``
* ``sonata.core.exporter.writer.csv.enclosure``: defaults to ``"``
* ``sonata.core.exporter.writer.csv.escape``: defaults to ``\\``
* ``sonata.core.exporter.writer.csv.show_headers``: defaults to ``true``
* ``sonata.core.exporter.writer.csv.with_bom``: defaults to ``false``

The Json writer service
~~~~~~~~~~~~~~~~~~~~~~~

Only the filename may be configured for this service:
``sonata.core.exporter.writer.json.filename``: defaults to ``php://output``

The Xls writer service
~~~~~~~~~~~~~~~~~~~~~~~

This service can be configured throught the following parameters:

* ``sonata.core.exporter.writer.xls.filename``: defaults to ``php://output``
* ``sonata.core.exporter.writer.xls.show_headers``: defaults to ``true``

The Xml writer service
~~~~~~~~~~~~~~~~~~~~~~~

This service can be configured throught the following parameters:

* ``sonata.core.exporter.writer.xml.filename``: defaults to ``php://output``
* ``sonata.core.exporter.writer.xml.show_headers``: defaults to ``true``
* ``sonata.core.exporter.writer.xml.main_element``: defaults to ``datas``
* ``sonata.core.exporter.writer.xml.child_element``: defaults to ``data``

Adding a custom writer to the list
----------------------------------

If you want to add a custom writer to the list of writers supported by the exporter,
you simply need to tag your service,
which must implement ``Exporter\Writer\TypedWriterInterface``,
with the ``sonata.core.exporter.writer`` tag.

Configuring the default writers
-------------------------------

The default writers list can be altered through configuration:

.. code-block:: yaml

    sonata_core:
        exporter:
            default_writers:
                - csv
                - json
