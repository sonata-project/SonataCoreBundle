UPGRADE 3.x
===========

A new bundle named `Sonata\Doctrine\Bridge\Symfony\Bundle\SonataDoctrineBundle`
should be registered in the kernel of your application.

The `ColorType` class is deprecated. Use 
`Symfony\Component\Form\Extension\Core\Type\ColorType` instead.

The `Sonata\CoreBundle\Color\Colors` class is deprecated.

A runtime has been introduced to lazy-load some extensions dependencies:
    - The methods `getFlashMessages()` and `getFlashMessagesTypes` of class
      `Sonata\CoreBundle\Twig\Extension\FlashMessageExtension` are deprecated.
    - The method `statusClass()` of class `Sonata\CoreBundle\Twig\Extension\StatusExtension`
      is deprecated.

Instead, use the associated runtimes: `FlashMessageRuntime` and `StatusRuntime`.

### Doctrine deprecations

All doctrine classes have been deprecated and were moved to `sonata-project/doctrine-extensions`:
 - `Model/Adapter/AdapterChain`
 - `Model/Adapter/AdapterInterface`
 - `Model/Adapter/DoctrineORMAdapter`
 - `Model/Adapter/DoctrinePHPCRAdapter`
 - `Model/BaseDocumentManager`
 - `Model/BaseEntityManager`
 - `Model/BaseManager`
 - `Model/BasePHPCRManager`
 - `Model/ManagerInterface`
 - `Model/PageableManagerInterface`
 
### Form deprecations

All form classes have been deprecated and were moved to the `Sonata\Form\` subnamespace:
 - `Sonata\CoreBundle\Date` => `Sonata\Form\Date`
 - `Sonata\CoreBundle\Form\DataMapper` => `Sonata\Form\DataMapper`
 - `Sonata\CoreBundle\Form\EventListener` => `Sonata\Form\EventListener`
 - `Sonata\CoreBundle\Form\Type` => `Sonata\Form\Type`
 - `Sonata\CoreBundle\Test\AbstractWidgetTestCase` => `Sonata\Form\Test\AbstractWidgetTestCase`
 - `Sonata\CoreBundle\Validator` => `Sonata\Form\Validator`
 
### Twig deprecations

All twig classes have been deprecated and were moved to the `Sonata\Twig\` subnamespace:
 - `Sonata\CoreBundle\Component\Status` => `Sonata\Twig\Status`
 - `Sonata\CoreBundle\FlashMessage` => `Sonata\Twig\FlashMessage`
 - `Sonata\CoreBundle\Twig\Extension` => `Sonata\Twig\Extension`
 - `Sonata\CoreBundle\Twig\Node` => `Sonata\Twig\Node`
 - `Sonata\CoreBundle\Twig\TokenParser` => `Sonata\Twig\TokenParser`
 
### Metadata deprecations

All meta classes have been deprecated and were moved to the `SonataBlockBundle`:
 - `Sonata\CoreBundle\Model\Metadata` => `Sonata\BlockBundle\Meta\Metadata`
 - `Sonata\CoreBundle\Model\MetadataInterface` => `Sonata\BlockBundle\Meta\MetadataInterface`
 
### Serializer deprecations

All serializer classes have been deprecated and were moved to the `Sonata\Serializer\` subnamespace:
 - `Sonata\CoreBundle\Serializer\BaseSerializerHandler` => `Sonata\Serializer\BaseSerializerHandler`
 - `Sonata\CoreBundle\Serializer\SerializerHandlerInterface` => `Sonata\Serializer\SerializerHandlerInterface`

UPGRADE FROM 3.6 to 3.7
=======================

Using the form mapping feature is now deprecated. You should use FQCNs
everywhere form names are used, and disable this feature with the following
piece of configuration:

```yaml
# config.yml
sonata_core:
    form:
        mapping:
            enabled: false
```

UPGRADE FROM 3.4 to 3.5
=======================

The `ColorSelectorType` class is deprecated. Use `ColorType` instead.

UPGRADE FROM 3.2 to 3.3
=======================

### AbstractWidgetTestCase::getRenderingEngine() mandatory argument

When using symfony/twig-bridge ^3.2.0,
`AbstractWidgetTestCase::getRenderingEngine()` requires a `Twig_Environment` instance.

Before:

```php
$this->getRenderingEngine();
```

After:

```php
$this->getRenderingEngine($environment);
```

UPGRADE FROM 3.1 to 3.2
=======================

### Deprecated truncate Twig filter

The twig/extensions `truncate` filter is no longer available through Sonata, create your own service to get it back.

UPGRADE FROM 3.0 to 3.1
=======================

### Tests

All files under the ``Tests`` directory are now correctly handled as internal test classes.
You can't extend them anymore, because they are only loaded when running internal tests.
More information can be found in the [composer docs](https://getcomposer.org/doc/04-schema.md#autoload-dev).

### Deprecated exporter class and service

The exporter class and service are now deprecated in favor of very similar equivalents from the
[`sonata-project/exporter`](https://github.com/sonata-project/exporter) library,
which are available since version 1.6.0,
if you enable the bundle as described in the documentation.

### BasePickerType needs a ``TranslatorInterface`` as 2nd argument

Before:

```php
    /**
     * @param MomentFormatConverter $formatConverter
     */
    public function __construct(MomentFormatConverter $formatConverter)
```

After:

```php
    /**
     * @param MomentFormatConverter $formatConverter
     * @param TranslatorInterface   $translator
     */
    public function __construct(MomentFormatConverter $formatConverter, TranslatorInterface $translator)
```
