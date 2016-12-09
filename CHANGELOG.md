# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

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
