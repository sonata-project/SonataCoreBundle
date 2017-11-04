# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.6.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.5.1...3.6.0) - 2017-11-04
### Added
- Added dp_option "dp_pick_date" in BasePickerType
- Support of cocur/slugify 3.x

### Changed
- Changed template datepicker.html.twig to display the time icon

### Fixed
- missing form mapping for `sonata_type_color`
- reusable test case `Sonata\CoreBundle\Test\AbstractWidgetTestCase` is now compatible with Symfony 3.4

### Removed
- Support for old versions of PHP and Symfony.

## [3.5.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.5.0...3.5.1) - 2017-09-20
### Fixed
- Datagrid build form issue caused by a regression on release 3.5.0

## [3.5.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.4.0...3.5.0) - 2017-09-19
### Added
- New ColorType form type that should give us easier color picking functioanlity instead of choice field with color names

### Changed
- Removed add of `FormFactoryCompilerPass` when the option `form.mapping.enabled` is `false`

### Deprecated
- Class `ColorSelectorType` is deprecated and replaced by `ColorType`

### Fixed
- fixed Twig errors when using `sonata_template_box` without a translation domain
- deprecation notices related to `addClassesToCompile`
- Fixed deprecation notice in `ColorSelectorType` for Sf 3. support
- Missing brazilian translations for color names and date_range messages.
- Fixed passing empty translation domain to `sonata_template_box`

## [3.4.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.3.0...3.4.0) - 2017-05-09
### Added
- Options for `ImmutableArrayType` are now validated, which should yield better results.

### Fixed
- compatibility with Symfony 3.3

## [3.3.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.2.0...3.3.0) - 2017-03-23
### Added
- `sonata-project/datagrid-bundle` dependency for `Sonata\CoreBundle\ModelPageableManagerInterface`

### Fixed
- deprecation notices in `AbstractWidgetTestCase`

## [3.2.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.1.2...3.2.0) - 2017-01-20
### Added
- Twig 2.0 compatibility
- Missing bootstrap datepicker options (`dp_collapse`, `dp_calendar_weeks`, `dp_view_mode`)

### Changed
- Moment library updated from 2.10.6 to 2.17.1

### Deprecated
- The truncate service was deprecated

## [3.1.2](https://github.com/sonata-project/SonataCoreBundle/compare/3.1.1...3.1.2) - 2016-12-09
### Added
- Added dutch (nl) date_range translations

### Changed
 - Use `choice_translation_domain` in `BooleanType`

### Fixed
- The abstract test case for testing widgets now works with Symfony 3.2

### Updated
- Updated Font Awesome from v4.6.3 to v4.7

## [3.1.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.1.0...3.1.1) - 2016-08-30
### Fixed
- Added interface check for `JMS\Serializer\Handler\SubscribingHandlerInterface` in `SonataCoreExtension::configureSerializerFormats`

## [3.1.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.0.3...3.1.0) - 2016-08-25
### Added
- Added `AbstractWidgetTestCase` test suite
- Added static `setFormats` and `addFormat` methods to `BaseSerializerHandler`
- Added `sonata.core.serializer.formats` configuration
- Added `AbstractWidgetTestCase::getTemplatePaths` method
- Added `AbstractWidgetTestCase::getEnvironment` method
- Added `AbstractWidgetTestCase::getRenderingEngine` method

### Deprecated
- Exporter class and service : use equivalents from `sonata-project/exporter` instead.
- Deprecated the translator in `DateRangeType`, `DateTimeRangeType` and `EqualType`

### Fixed
- Fixed `BaseDoctrineORMSerializationType::buildForm` compatibility with Symfony3 forms
- Fixed `BaseStatusType::getParent ` compatibility with Symfony3 forms
- Fixed `CollectionType::configureOptions` compatibility with Symfony3 forms
- Fixed `DateRangePickerType::configureOptions` compatibility with Symfony3 forms
- Fixed `DateRangeType::configureOptions` compatibility with Symfony3 forms
- Fixed `DateTimeRangePickerType::configureOptions` compatibility with Symfony3 forms
- Fixed `DateTimeRangeType::configureOptions` compatibility with Symfony3 forms
- Removed duplicate translation in `DateRangeType`, `DateTimeRangeType` and `EqualType`

### Removed
- Internal test classes are now excluded from the autoloader
- Removed `AbstractWidgetTestCase::getTwigExtensions` method

## [3.0.3](https://github.com/sonata-project/SonataCoreBundle/compare/3.0.2...3.0.3) - 2016-06-17
### Fixed
- Add missing exporter service

## [3.0.2](https://github.com/sonata-project/SonataCoreBundle/compare/3.0.1...3.0.2) - 2016-06-06
### Fixed
- Fixed `EntityManagerMockFactory` calling protected methods. This class is used by other bundles for testing.

## [3.0.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.0.0...3.0.1) - 2016-06-01
### Changed
- Updated Bootstrap from version 3.3.5 to version 3.3.6
- Updated Font-awesome from version 4.5.0 to version 4.6.3

### Fixed
- Typo on `choices_as_values` option for `EqualType`
