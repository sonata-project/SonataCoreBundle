Flash Messages
==============

The bundle comes with a ``FlashManager`` to handle some session flash messages types you can specify in the configuration
to be returned as a ``success``, ``warning`` or ``error`` type.

Configuration
^^^^^^^^^^^^^

.. code-block:: yaml

    sonata_core:
        flashmessage:
            success:
                - my_custom_bundle_success: { domain: MyCustomBundle }
                - my_other_bundle_success: { domain: MyOtherBundle }
            warning:
                - my_custom_bundle_warning: { domain: MyCustomBundle }
                - my_other_bundle_warning: # if nothing is specified, sets SonataCoreBundle by default
            error:
                - my_custom_bundle: { domain: MyCustomBundle }

You can specify multiple flash messages types you want to manage here.

How-to use
^^^^^^^^^^

To use this feature in your PHP classes/controllers, you can use, for example:

.. code-block: php

    <?php

    $this->get('sonata.core.flashmessage.manager')
    $messages = $flashManager->get('success');

To use this feature in your templates, simply include the following template (with an optional domain parameter):

.. code-block:: twig

    {% include 'SonataCoreBundle:FlashMessage:render.html.twig' %}

Please note that if necessary, you can also specify a translation domain to override configuration here:

.. code-block:: twig

    {% include 'SonataCoreBundle:FlashMessage:render.html.twig' with {domain: 'MyCustomBundle'} %}