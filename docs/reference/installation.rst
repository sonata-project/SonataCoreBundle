.. index::
    single: Installation

Installation
============

Download the Bundle
-------------------

.. code-block:: bash

    composer require sonata-project/core-bundle

Enable the Bundle
-----------------

Then, enable the bundle by adding it to the list of registered bundles
in ``bundles.php`` file of your project::

    // config/bundles.php

    return [
        // ...
        Sonata\CoreBundle\SonataCoreBundle::class => ['all' => true],
    ];

Configuration
=============

.. configuration-block::

    .. code-block:: yaml

        # config/packages/sonata_core.yaml

        sonata_core:
            form:
                mapping:
                    enabled: false

When using bootstrap, some widgets need to be wrapped in a special ``div`` element
depending on whether you are using the standard style for your forms or the
horizontal style.

If you are using the horizontal style, you will need to configure the
corresponding configuration node accordingly:

.. configuration-block::

    .. code-block:: yaml

        # config/packages/sonata_core.yaml

        sonata_core:
            form_type: horizontal

.. note::

    Please note that if you are using SonataAdminBundle, this is actually optional:

    The SonataCoreBundle extension will detect if the configuration node that deals with
    the form style in the admin bundle is set and will configure the core bundle for you.
