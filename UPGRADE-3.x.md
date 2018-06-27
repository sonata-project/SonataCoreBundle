UPGRADE 3.x
===========

The `ColorType` class is deprecated. Use 
`Symfony\Component\Form\Extension\Core\Type\ColorType` instead.

The `Sonata\CoreBundle\Color\Colors` class is deprecated.

A runtime has been introduced to lazy-load some extensions dependencies:
    - The methods `getFlashMessages()` and `getFlashMessagesTypes` of class
      `Sonata\CoreBundle\Twig\Extension\FlashMessageExtension` are deprecated.
    - The method `statusClass()` of class `Sonata\CoreBundle\Twig\Extension\StatusExtension`
      is deprecated.

Instead, use the associated runtimes: `FlashMessageRuntime` and `StatusRuntime`.

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
