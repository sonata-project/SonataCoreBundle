<?php

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
use Sonata\CoreBundle\DependencyInjection\Compiler\FormFactoryCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Sonata\CoreBundle\DependencyInjection\SonataCoreExtension;
use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\SonataCoreBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class SonataCoreBundleTest extends TestCase
{
    public function testBuild()
    {
        $containerBuilder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->setMethods(['addCompilerPass'])
            ->getMock();

        $containerBuilder->expects($this->any())
            ->method('addCompilerPass')
            ->will($this->returnCallback(function (CompilerPassInterface $pass) {
                if ($pass instanceof StatusRendererCompilerPass) {
                    return;
                }

                if ($pass instanceof AdapterCompilerPass) {
                    return;
                }

                if ($pass instanceof FormFactoryCompilerPass) {
                    return;
                }

                $this->fail(sprintf(
                    'Compiler pass is not one of the expected types.
                    Expects "Sonata\AdminBundle\DependencyInjection\Compiler\StatusRendererCompilerPass",
                    "Sonata\AdminBundle\DependencyInjection\Compiler\AdapterCompilerPass" or
                    "Sonata\AdminBundle\DependencyInjection\Compiler\FormFactoryCompilerPass", but got "%s".',
                    get_class($pass)
                ));
            }));

        $bundle = new SonataCoreBundle();
        $bundle->build($containerBuilder);

        $this->assertMappingTypeRegistered('form', 'Symfony\Component\Form\Extension\Core\Type\FormType');
    }

    public function testBootCallsRegisterFormMapping()
    {
        $bundle = new SonataCoreBundle();
        $bundle->boot();

        $this->assertMappingTypeRegistered('form', 'Symfony\Component\Form\Extension\Core\Type\FormType');
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
            ['form', 'Symfony\Component\Form\Extension\Core\Type\FormType'],
            ['birthday', 'Symfony\Component\Form\Extension\Core\Type\BirthdayType'],
            ['checkbox', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType'],
            ['choice', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType'],
            ['collection', 'Symfony\Component\Form\Extension\Core\Type\CollectionType'],
            ['country', 'Symfony\Component\Form\Extension\Core\Type\CountryType'],
            ['date', 'Symfony\Component\Form\Extension\Core\Type\DateType'],
            ['datetime', 'Symfony\Component\Form\Extension\Core\Type\DateTimeType'],
            ['email', 'Symfony\Component\Form\Extension\Core\Type\EmailType'],
            ['file', 'Symfony\Component\Form\Extension\Core\Type\FileType'],
            ['hidden', 'Symfony\Component\Form\Extension\Core\Type\HiddenType'],
            ['integer', 'Symfony\Component\Form\Extension\Core\Type\IntegerType'],
            ['language', 'Symfony\Component\Form\Extension\Core\Type\LanguageType'],
            ['locale', 'Symfony\Component\Form\Extension\Core\Type\LocaleType'],
            ['money', 'Symfony\Component\Form\Extension\Core\Type\MoneyType'],
            ['number', 'Symfony\Component\Form\Extension\Core\Type\NumberType'],
            ['password', 'Symfony\Component\Form\Extension\Core\Type\PasswordType'],
            ['percent', 'Symfony\Component\Form\Extension\Core\Type\PercentType'],
            ['radio', 'Symfony\Component\Form\Extension\Core\Type\RadioType'],
            ['repeated', 'Symfony\Component\Form\Extension\Core\Type\RepeatedType'],
            ['search', 'Symfony\Component\Form\Extension\Core\Type\SearchType'],
            ['textarea', 'Symfony\Component\Form\Extension\Core\Type\TextareaType'],
            ['text', 'Symfony\Component\Form\Extension\Core\Type\TextType'],
            ['time', 'Symfony\Component\Form\Extension\Core\Type\TimeType'],
            ['timezone', 'Symfony\Component\Form\Extension\Core\Type\TimezoneType'],
            ['url', 'Symfony\Component\Form\Extension\Core\Type\UrlType'],
            ['button', 'Symfony\Component\Form\Extension\Core\Type\ButtonType'],
            ['submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType'],
            ['reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType'],
            ['currency', 'Symfony\Component\Form\Extension\Core\Type\CurrencyType'],
            ['entity', 'Symfony\Bridge\Doctrine\Form\Type\EntityType'],
            ['sonata_type_immutable_array', 'Sonata\CoreBundle\Form\Type\ImmutableArrayType'],
            ['sonata_type_boolean', 'Sonata\CoreBundle\Form\Type\BooleanType'],
            ['sonata_type_collection', 'Sonata\CoreBundle\Form\Type\CollectionType'],
            ['sonata_type_date_range', 'Sonata\CoreBundle\Form\Type\DateRangeType'],
            ['sonata_type_datetime_range', 'Sonata\CoreBundle\Form\Type\DateTimeRangeType'],
            ['sonata_type_date_picker', 'Sonata\CoreBundle\Form\Type\DatePickerType'],
            ['sonata_type_datetime_picker', 'Sonata\CoreBundle\Form\Type\DateTimePickerType'],
            ['sonata_type_date_range_picker', 'Sonata\CoreBundle\Form\Type\DateRangePickerType'],
            ['sonata_type_datetime_range_picker', 'Sonata\CoreBundle\Form\Type\DateTimeRangePickerType'],
            ['sonata_type_equal', 'Sonata\CoreBundle\Form\Type\EqualType'],
            ['sonata_type_color', 'Sonata\CoreBundle\Form\Type\ColorType'],
            ['sonata_type_color_selector', 'Sonata\CoreBundle\Form\Type\ColorSelectorType'],
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

        $container = $this->createMock('Symfony\Component\DependencyInjection\ContainerInterface');

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

        $reflectedBundle = new \ReflectionClass('Sonata\CoreBundle\SonataCoreBundle');
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
