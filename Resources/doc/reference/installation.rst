Installation
============

* Add SonataNewsBundle to your vendor/bundles dir with the deps file::

.. code-block:: json

    //composer.json
    "require": {
    //...
        "sonata-project/core-bundle": "~2.2@dev",
    //...
    }


* Add SonataCoreBundle to your application kernel::

.. code-block:: php

    <?php

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Sonata\CoreBundle\SonataCoreBundle(),
            // ...
        );
    }

* Create a configuration file : ``sonata_core.yml``::

.. code-block:: yaml

    sonata_core: ~

* import the ``sonata_core.yml`` file in the ``config.yml`` file ::

.. code-block:: yaml

    imports:
        #...
        - { resource: sonata_core.yml }
