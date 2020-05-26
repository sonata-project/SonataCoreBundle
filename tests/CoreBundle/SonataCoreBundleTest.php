<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\DependencyInjection\Compiler\AdapterCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\FormCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\FormFactoryCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\TwigCompilerPass;
use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\ColorSelectorType;
use Sonata\CoreBundle\Form\Type\ColorType;
use Sonata\CoreBundle\Form\Type\TranslatableChoiceType;
use Sonata\CoreBundle\SonataCoreBundle;
use Sonata\Form\Type\BooleanType;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;
use Sonata\Form\Type\DateRangePickerType;
use Sonata\Form\Type\DateRangeType;
use Sonata\Form\Type\DateTimePickerType;
use Sonata\Form\Type\DateTimeRangePickerType;
use Sonata\Form\Type\DateTimeRangeType;
use Sonata\Form\Type\EqualType;
use Sonata\Form\Type\ImmutableArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType as SymfonyCollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class SonataCoreBundleTest extends TestCase
{
    public function testBuild()
    {
        $containerBuilder = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['addCompilerPass'])
            ->getMock();

        $containerBuilder->expects($this->any())
            ->method('addCompilerPass')
            ->willReturnCallback(function (CompilerPassInterface $pass) {
                if ($pass instanceof StatusRendererCompilerPass) {
                    return;
                }

                if ($pass instanceof AdapterCompilerPass) {
                    return;
                }

                if ($pass instanceof FormFactoryCompilerPass) {
                    return;
                }

                if ($pass instanceof FormCompilerPass) {
                    return;
                }

                if ($pass instanceof TwigCompilerPass) {
                    return;
                }

                $this->fail(sprintf(
                    'Compiler pass is not one of the expected types.
                    Expects "Sonata\AdminBundle\DependencyInjection\Compiler\StatusRendererCompilerPass",
                    "Sonata\CoreBundle\DependencyInjection\Compiler\AdapterCompilerPass" or
                    "Sonata\CoreBundle\DependencyInjection\Compiler\FormFactoryCompilerPass or
                    "Sonata\CoreBundle\DependencyInjection\Compiler\FormCompilerPass or
                    "Sonata\CoreBundle\DependencyInjection\Compiler\TwigCompilerPass", but got "%s".',
                    \get_class($pass)
                ));
            });

        $bundle = new SonataCoreBundle();
        $bundle->build($containerBuilder);

        $this->assertMappingTypeRegistered('form', FormType::class);
    }

    public function testBootCallsRegisterFormMapping()
    {
        $bundle = new SonataCoreBundle();
        $bundle->boot();

        $this->assertMappingTypeRegistered('form', FormType::class);
    }

    /**
     * @dataProvider getRegisteredFormMappingAndTypes
     *
     * @param string $mapping
     * @param string $type
     */
    public function testRegisterFormTypeMapping($mapping, $type)
    {
        $bundle = new SonataCoreBundle();
        $bundle->registerFormMapping();

        $this->assertMappingTypeRegistered($mapping, $type);
    }

    public function getRegisteredFormMappingAndTypes()
    {
        return [
            ['form', FormType::class],
            ['birthday', BirthdayType::class],
            ['checkbox', CheckboxType::class],
            ['choice', ChoiceType::class],
            ['collection', SymfonyCollectionType::class],
            ['country', CountryType::class],
            ['date', DateType::class],
            ['datetime', DateTimeType::class],
            ['email', EmailType::class],
            ['file', FileType::class],
            ['hidden', HiddenType::class],
            ['integer', IntegerType::class],
            ['language', LanguageType::class],
            ['locale', LocaleType::class],
            ['money', MoneyType::class],
            ['number', NumberType::class],
            ['password', PasswordType::class],
            ['percent', PercentType::class],
            ['radio', RadioType::class],
            ['repeated', RepeatedType::class],
            ['search', SearchType::class],
            ['textarea', TextareaType::class],
            ['text', TextType::class],
            ['time', TimeType::class],
            ['timezone', TimezoneType::class],
            ['url', UrlType::class],
            ['button', ButtonType::class],
            ['submit', SubmitType::class],
            ['reset', ResetType::class],
            ['currency', CurrencyType::class],
            ['entity', EntityType::class],
            ['sonata_type_immutable_array', ImmutableArrayType::class],
            ['sonata_type_boolean', BooleanType::class],
            ['sonata_type_collection', CollectionType::class],
            ['sonata_type_translatable_choice', TranslatableChoiceType::class],
            ['sonata_type_date_range', DateRangeType::class],
            ['sonata_type_datetime_range', DateTimeRangeType::class],
            ['sonata_type_date_picker', DatePickerType::class],
            ['sonata_type_datetime_picker', DateTimePickerType::class],
            ['sonata_type_date_range_picker', DateRangePickerType::class],
            ['sonata_type_datetime_range_picker', DateTimeRangePickerType::class],
            ['sonata_type_equal', EqualType::class],
            ['sonata_type_color', ColorType::class],
            ['sonata_type_color_selector', ColorSelectorType::class],
        ];
    }

    /**
     * @dataProvider getRegisteredFormMappingAndExtensions
     *
     * @param string $mapping
     * @param string $extension
     */
    public function testRegisterFormExtensionMapping($mapping, $extension)
    {
        $bundle = new SonataCoreBundle();
        $bundle->registerFormMapping();

        $this->assertMappingExtensionRegistered($mapping, $extension);
    }

    public function getRegisteredFormMappingAndExtensions()
    {
        return [
            ['form', 'form.type_extension.form.http_foundation'],
            ['form', 'form.type_extension.form.validator'],
            ['form', 'form.type_extension.csrf'],
            ['form', 'form.type_extension.form.data_collector'],
            ['form', 'nelmio_api_doc.form.extension.description_form_type_extension'],
            ['repeated', 'form.type_extension.repeated.validator'],
            ['submit', 'form.type_extension.submit.validator'],
        ];
    }

    public function testRegisterFormMappingWithContainer()
    {
        $bundle = new SonataCoreBundle();

        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->once())
            ->method('hasParameter')
            ->willReturn(true);

        $container->expects($this->at(1))
            ->method('getParameter')
            ->with('sonata.core.form.mapping.type')
            ->willReturn(['fooMapping' => 'barType']);

        $container->expects($this->at(2))
            ->method('getParameter')
            ->with('sonata.core.form.mapping.extension')
            ->willReturn(['fooMapping' => ['barExtension']]);

        $reflectedBundle = new \ReflectionClass(SonataCoreBundle::class);
        $reflectedContainer = $reflectedBundle->getProperty('container');
        $reflectedContainer->setAccessible(true);
        $reflectedContainer->setValue($bundle, $container);

        $bundle->registerFormMapping();

        $this->assertMappingTypeRegistered('fooMapping', 'barType');
        $this->assertMappingExtensionRegistered('fooMapping', 'barExtension');
    }

    /**
     * Asserts mapping type registered.
     *
     * @param string $mapping
     * @param string $type
     */
    private function assertMappingTypeRegistered($mapping, $type)
    {
        $registeredMapping = FormHelper::getFormTypeMapping();

        $this->assertArrayHasKey($mapping, $registeredMapping);
        $this->assertSame($type, $registeredMapping[$mapping]);
    }

    /**
     * Asserts mapping extension registered.
     *
     * @param string $mapping
     * @param string $extension
     */
    private function assertMappingExtensionRegistered($mapping, $extension)
    {
        $registeredMapping = FormHelper::getFormExtensionMapping();

        $this->assertArrayHasKey($mapping, $registeredMapping);
        $this->assertContains($extension, $registeredMapping[$mapping]);
    }
}
