.. index::
    double: Twig Helpers; Definition

Twig Helpers
============

sonata_flashmessages_get and sonata_flashmessages_types
-------------------------------------------------------

See :doc:`flash_messages` for more information.

sonata_urlsafeid
----------------

Gets the identifiers of the object as a string that is safe to use in an url.

sonata_template_deprecate
-------------------------
Node that can be used to deprecate a template. You have to provide a string that represents a new template and
this argument is mandatory.

.. code-block:: jinja

    {% sonata_template_deprecate 'new_template.html.twig' %}

Triggers deprecation with a message: ::

    The "current_template.html.twig" template is deprecated. Use "new_template.html.twig" instead.

In this example we used ``{% sonata_template_deprecate 'new_template.html.twig' %}`` inside of ``current_template.html.twig`` template.
