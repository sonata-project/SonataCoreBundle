# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.11.2](https://github.com/sonata-project/SonataCoreBundle/compare/3.11.1...3.11.2) - 2018-07-19
### Fixed
- Handle null values in BooleanTypeToBooleanTransformer

## [3.11.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.11.0...3.11.1) - 2018-07-12
### Fixed
- Fix compatibility with Symfony 2.8 regarding Twig runtimes

## [3.11.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.10.0...3.11.0) - 2018-07-08

### Added
- Added `FlashMessageRuntime` and `StatusRuntime` to remove strong dependency on the session introduced by Twig extensions

## [3.10.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.9.1...3.10.0) - 2018-06-12
### Fixed
- `fputcsv()` default escape character
- `SonataListFormMappingCommand::isEnabled` to only enable the command when Symfony Major Version < 3

### Added
- [Date(Time)PickerType] Handle field without seconds with option `dp_use_seconds`.
- [Date(Time)PickerType] Allow DateTime Object in `dp_min_date` and `dp_max_date`
- [Date(Time)RangePickerType] Link DateTimeRange pickers to keep start < end

### Deprecated
- `ColorType` has been deprecated
- `Colors` class has been deprecated

## [3.9.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.9.0...3.9.1) - 2018-02-23
### Fixed
- Missing deprecation alert for `sonata.core.slugify.native` service

### Changed
- changed composer dependency from `symfony/security` to `symfony/security-csrf`
- Services for slugify strings are marked as public

## [3.9.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.8.0...3.9.0) - 2018-01-07
### Added
- Added close label to flash messages

### Changed
- Always flip choices in `BaseStatusType`

## [3.8.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.7.1...3.8.0) - 2017-12-16
### Added
- Added Russian translations
- Added twig extension for deprecating templates

### Changed
- Avoid inheritance from deprecated FormPass

### Fixed
- Deprecation about `FormPass` can now be avoided
- Fixed deprecation message in `ColorSelectorType`

## [3.7.1](https://github.com/sonata-project/SonataCoreBundle/compare/3.7.0...3.7.1) - 2017-11-30
### Fixed
- It is now allowed to install Symfony 4

## [3.7.0](https://github.com/sonata-project/SonataCoreBundle/compare/3.6.0...3.7.0) - 2017-11-19
### Deprecated
- the form mapping feature

### Fixed
- Register commands as services to prevent deprecation notices on Symfony 3.4
- `twig_truncate_filter`, and `twig_wordwrap_filter` were broken
- `twig_truncate_filter`, and `twig_wordwrap_filter` were not properly deprecated
- forward-compatibility with sf4
- form mapping feature removal on sf4, it is now properly disabled

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
