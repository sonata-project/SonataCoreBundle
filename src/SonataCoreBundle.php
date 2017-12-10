<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle;

use Nelmio\ApiDocBundle\Form\Extension\DescriptionFormTypeExtension;
use Sonata\CoreBundle\DependencyInjection\Compiler\AdapterCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\FormFactoryCompilerPass;
use Sonata\CoreBundle\DependencyInjection\Compiler\StatusRendererCompilerPass;
use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\ColorSelectorType;
use Sonata\CoreBundle\Form\Type\ColorType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateRangePickerType;
use Sonata\CoreBundle\Form\Type\DateRangeType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangePickerType;
use Sonata\CoreBundle\Form\Type\DateTimeRangeType;
use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\CoreBundle\Form\Type\TranslatableChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SonataCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StatusRendererCompilerPass());
        $container->addCompilerPass(new AdapterCompilerPass());
        $container->addCompilerPass(new FormFactoryCompilerPass());

        $this->registerFormMapping();
    }

    public function boot()
    {
        // not sur we need this at Runtime ...
        $this->registerFormMapping();
    }

    /**
     * Register form mapping information.
     */
    public function registerFormMapping()
    {
        // symfony
        FormHelper::registerFormTypeMapping([
            'form' => FormType::class,
            'birthday' => BirthdayType::class,
            'checkbox' => CheckboxType::class,
            'choice' => ChoiceType::class,
            'collection' => SymfonyCollectionType::class,
            'country' => CountryType::class,
            'date' => DateType::class,
            'datetime' => DateTimeType::class,
            'email' => EmailType::class,
            'file' => FileType::class,
            'hidden' => HiddenType::class,
            'integer' => IntegerType::class,
            'language' => LanguageType::class,
            'locale' => LocaleType::class,
            'money' => MoneyType::class,
            'number' => NumberType::class,
            'password' => PasswordType::class,
            'percent' => PercentType::class,
            'radio' => RadioType::class,
            'repeated' => RepeatedType::class,
            'search' => SearchType::class,
            'textarea' => TextareaType::class,
            'text' => TextType::class,
            'time' => TimeType::class,
            'timezone' => TimezoneType::class,
            'url' => UrlType::class,
            'button' => ButtonType::class,
            'submit' => SubmitType::class,
            'reset' => ResetType::class,
            'currency' => CurrencyType::class,
            'entity' => EntityType::class,
        ]);

        // core bundle
        FormHelper::registerFormTypeMapping([
            'sonata_type_immutable_array' => ImmutableArrayType::class,
            'sonata_type_boolean' => BooleanType::class,
            'sonata_type_collection' => CollectionType::class,
            'sonata_type_translatable_choice' => TranslatableChoiceType::class,
            'sonata_type_date_range' => DateRangeType::class,
            'sonata_type_datetime_range' => DateTimeRangeType::class,
            'sonata_type_date_picker' => DatePickerType::class,
            'sonata_type_datetime_picker' => DateTimePickerType::class,
            'sonata_type_date_range_picker' => DateRangePickerType::class,
            'sonata_type_datetime_range_picker' => DateTimeRangePickerType::class,
            'sonata_type_equal' => EqualType::class,
            'sonata_type_color' => ColorType::class,
            'sonata_type_color_selector' => ColorSelectorType::class,
        ]);

        $formTypes = [
            'form.type_extension.form.http_foundation',
            'form.type_extension.form.validator',
            'form.type_extension.csrf',
            'form.type_extension.form.data_collector',
        ];

        if (class_exists(DescriptionFormTypeExtension::class)) {
            $formTypes[] = 'nelmio_api_doc.form.extension.description_form_type_extension';
        }

        FormHelper::registerFormExtensionMapping('form', $formTypes);

        FormHelper::registerFormExtensionMapping('repeated', [
            'form.type_extension.repeated.validator',
        ]);

        FormHelper::registerFormExtensionMapping('submit', [
            'form.type_extension.submit.validator',
        ]);

        if ($this->container && $this->container->hasParameter('sonata.core.form.mapping.type')) {
            // from configuration file
            FormHelper::registerFormTypeMapping($this->container->getParameter('sonata.core.form.mapping.type'));
            foreach ($this->container->getParameter('sonata.core.form.mapping.extension') as $ext => $types) {
                FormHelper::registerFormExtensionMapping($ext, $types);
            }
        }
    }
}
