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
                - a_bundle_success
                - other_bundle_success
            warning:
                - a_bundle_warning
                - other_bundle_warning
            error:
                - a_bundle_error
                - other_bundle_error

You can specify multiple flash messages types you want to manage here.

How-to use
^^^^^^^^^^

To use this feature in your PHP classes/controllers, you can use, for example:

.. code-block: php

    <?php

    $this->get('sonata.core.flashmessage.manager')
    $messages = $flashManager->get('success');

To use this feature in your templates, simply use the following Twig function:

.. code-block:: twig

    {% for type in ['success', 'error', 'warning'] %}
        {% for message in sonata_flashmessages_get(type) %}
            <div class="alert alert-{{ type }}">
                {{ message }}
            </div>
        {% endfor %}
    {% endfor %}