.. index::
    double: Twig Status Helpers; Definition

Twig status helper
==================

The bundle comes with a `Twig` helper allowing you to generate CSS class names, depending on an entity field.

Define a service
----------------

Each service you want to define must implement the ``Sonata\Twig\Status\StatusClassRendererInterface`` interface::

    namespace Sonata\Component\Order;

    use Sonata\Twig\Status\StatusClassRendererInterface;

    class OrderStatusRenderer implements StatusClassRendererInterface
    {
        public function handlesObject($object, $statusName = null)
        {
            // Logic validating if the render is applicable for the given object
        }

        public function getStatusClass($object, $statusName = null, $default = "")
        {
            // Label to render
        }
    }

Now that we have defined our service, we will add it using the ``sonata.status.renderer`` tag, just as follow:

.. configuration-block::

    .. code-block:: xml

        <service id="sonata.order.status.renderer" class="Sonata\Component\Order\OrderStatusRenderer">
            <tag name="sonata.status.renderer"/>
        </service>

    .. code-block:: yaml

        services:
            sonata.order.status.renderer:
                class:  Sonata\Component\Order\OrderStatusRenderer
                tags:
                    - { name: sonata.status.renderer }

Use the service
---------------

You can now call your helper in your twig views using the following code:

.. code-block:: jinja

    {{ my_object|sonata_status_class(status_name, 'default_value') }}
