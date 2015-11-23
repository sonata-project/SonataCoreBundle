<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormHelper
{
    /**
     * This function remove fields available if there are not present in the $data array
     * The data array might come from $request->request->all().
     *
     * This can be usefull if you don't want to send all fields will building an api. As missing
     * fields will be threated like null values.
     *
     * @param array $data
     * @param Form  $form
     */
    public static function removeFields(array $data, Form $form)
    {
        $diff = array_diff(array_keys($form->all()), array_keys($data));

        foreach ($diff as $key) {
            $form->remove($key);
        }

        foreach ($data as $name => $value) {
            if (!is_array($value)) {
                continue;
            }

            self::removeFields($value, $form[$name]);
        }
    }

    /**
     * @return array
     */
    public static function getFormExtensionMapping()
    {
        return array(
            'form'                      => array(
                'form.type_extension.form.http_foundation',
                'form.type_extension.form.validator',
                'form.type_extension.csrf',
                'form.type_extension.form.data_collector',
                'sonata.admin.form.extension.field',
                'nelmio_api_doc.form.extension.description_form_type_extension',
                'mopa_bootstrap.form.type_extension.help',
                'mopa_bootstrap.form.type_extension.legend',
                'mopa_bootstrap.form.type_extension.error',
                'mopa_bootstrap.form.type_extension.widget',
                'mopa_bootstrap.form.type_extension.horizontal',
                'mopa_bootstrap.form.type_extension.widget_collection',
                'mopa_bootstrap.form.type_extension.tabbed',
            ),
            'repeated'                  => array(
                'form.type_extension.repeated.validator',
            ),
            'submit'                    => array(
                'form.type_extension.submit.validator',
            ),
            'choice'                    => array(
                'sonata.admin.form.extension.choice',
            ),
            'sonata_demo_form_type_car' => array(
                'sonata.demo.form.type.advanced_rescue_engine',
            ),
            'button'                    => array(
                'mopa_bootstrap.form.type_extension.button',
            ),
            'date'                      => array(
                'mopa_bootstrap.form.type_extension.date',
            ),
        );
    }

    /**
     * @return array
     */
    public static function getFormTypeMapping()
    {
        return array(
            'form'                                         => 'Symfony\Component\Form\Extension\Core\Type\FormType',
            'birthday'                                     => 'Symfony\Component\Form\Extension\Core\Type\BirthdayType',
            'checkbox'                                     => 'Symfony\Component\Form\Extension\Core\Type\CheckboxType',
            'choice'                                       => 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
            'collection'                                   => 'Symfony\Component\Form\Extension\Core\Type\CollectionType',
            'country'                                      => 'Symfony\Component\Form\Extension\Core\Type\CountryType',
            'date'                                         => 'Symfony\Component\Form\Extension\Core\Type\DateType',
            'datetime'                                     => 'Symfony\Component\Form\Extension\Core\Type\DateTimeType',
            'email'                                        => 'Symfony\Component\Form\Extension\Core\Type\EmailType',
            'file'                                         => 'Symfony\Component\Form\Extension\Core\Type\FileType',
            'hidden'                                       => 'Symfony\Component\Form\Extension\Core\Type\HiddenType',
            'integer'                                      => 'Symfony\Component\Form\Extension\Core\Type\IntegerType',
            'language'                                     => 'Symfony\Component\Form\Extension\Core\Type\LanguageType',
            'locale'                                       => 'Symfony\Component\Form\Extension\Core\Type\LocaleType',
            'money'                                        => 'Symfony\Component\Form\Extension\Core\Type\MoneyType',
            'number'                                       => 'Symfony\Component\Form\Extension\Core\Type\NumberType',
            'password'                                     => 'Symfony\Component\Form\Extension\Core\Type\PasswordType',
            'percent'                                      => 'Symfony\Component\Form\Extension\Core\Type\PercentType',
            'radio'                                        => 'Symfony\Component\Form\Extension\Core\Type\RadioType',
            'repeated'                                     => 'Symfony\Component\Form\Extension\Core\Type\RepeatedType',
            'search'                                       => 'Symfony\Component\Form\Extension\Core\Type\SearchType',
            'textarea'                                     => 'Symfony\Component\Form\Extension\Core\Type\TextareaType',
            'text'                                         => 'Symfony\Component\Form\Extension\Core\Type\TextType',
            'time'                                         => 'Symfony\Component\Form\Extension\Core\Type\TimeType',
            'timezone'                                     => 'Symfony\Component\Form\Extension\Core\Type\TimezoneType',
            'url'                                          => 'Symfony\Component\Form\Extension\Core\Type\UrlType',
            'button'                                       => 'Symfony\Component\Form\Extension\Core\Type\ButtonType',
            'submit'                                       => 'Symfony\Component\Form\Extension\Core\Type\SubmitType',
            'reset'                                        => 'Symfony\Component\Form\Extension\Core\Type\ResetType',
            'currency'                                     => 'Symfony\Component\Form\Extension\Core\Type\CurrencyType',
            'entity'                                       => 'Symfony\Bridge\Doctrine\Form\Type\EntityType',
            'fos_user_username'                            => 'FOS\UserBundle\Form\Type\UsernameFormType',
            'fos_user_profile'                             => 'FOS\UserBundle\Form\Type\ProfileFormType',
            'fos_user_registration'                        => 'FOS\UserBundle\Form\Type\RegistrationFormType',
            'fos_user_change_password'                     => 'FOS\UserBundle\Form\Type\ChangePasswordFormType',
            'fos_user_resetting'                           => 'FOS\UserBundle\Form\Type\ResettingFormType',
            'fos_user_group'                               => 'FOS\UserBundle\Form\Type\GroupFormType',
            'sonata_security_roles'                        => 'Sonata\UserBundle\Form\Type\SecurityRolesType',
            'sonata_user_profile'                          => 'Sonata\UserBundle\Form\Type\ProfileType',
            'sonata_user_gender'                           => 'Sonata\UserBundle\Form\Type\UserGenderListType',
            'sonata_user_registration'                     => 'Sonata\UserBundle\Form\Type\RegistrationFormType',
            'sonata_user_api_form_group'                   => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_user_api_form_user'                    => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_page_api_form_site'                    => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_page_api_form_page'                    => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_page_api_form_block'                   => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_page_selector'                         => 'Sonata\PageBundle\Form\Type\PageSelectorType',
            'sonata_page_create_snapshot'                  => 'Sonata\PageBundle\Form\Type\CreateSnapshotType',
            'sonata_page_template'                         => 'Sonata\PageBundle\Form\Type\TemplateChoiceType',
            'sonata_page_type_choice'                      => 'Sonata\PageBundle\Form\Type\PageTypeChoiceType',
            'sonata_post_comment'                          => 'Sonata\NewsBundle\Form\Type\CommentType',
            'sonata_news_comment_status'                   => 'Sonata\NewsBundle\Form\Type\CommentStatusType',
            'sonata_news_api_form_comment'                 => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_news_api_form_post'                    => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_media_type'                            => 'Sonata\MediaBundle\Form\Type\MediaType',
            'sonata_media_api_form_doctrine_media'         => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_media_api_form_media'                  => 'Sonata\MediaBundle\Form\Type\ApiMediaType',
            'sonata_media_api_form_gallery'                => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_media_api_form_gallery_has_media'      => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'ckeditor'                                     => 'Ivory\CKEditorBundle\Form\Type\CKEditorType',
            'sonata_type_admin'                            => 'Sonata\AdminBundle\Form\Type\AdminType',
            'sonata_type_model'                            => 'Sonata\AdminBundle\Form\Type\ModelType',
            'sonata_type_model_list'                       => 'Sonata\AdminBundle\Form\Type\ModelTypeList',
            'sonata_type_model_reference'                  => 'Sonata\AdminBundle\Form\Type\ModelReferenceType',
            'sonata_type_model_hidden'                     => 'Sonata\AdminBundle\Form\Type\ModelHiddenType',
            'sonata_type_model_autocomplete'               => 'Sonata\AdminBundle\Form\Type\ModelAutocompleteType',
            'sonata_type_native_collection'                => 'Sonata\AdminBundle\Form\Type\CollectionType',
            'sonata_type_choice_field_mask'                => 'Sonata\AdminBundle\Form\Type\ChoiceFieldMaskType',
            'sonata_type_filter_number'                    => 'Sonata\AdminBundle\Form\Type\Filter\NumberType',
            'sonata_type_filter_choice'                    => 'Sonata\AdminBundle\Form\Type\Filter\ChoiceType',
            'sonata_type_filter_default'                   => 'Sonata\AdminBundle\Form\Type\Filter\DefaultType',
            'sonata_type_filter_date'                      => 'Sonata\AdminBundle\Form\Type\Filter\DateType',
            'sonata_type_filter_date_range'                => 'Sonata\AdminBundle\Form\Type\Filter\DateRangeType',
            'sonata_type_filter_datetime'                  => 'Sonata\AdminBundle\Form\Type\Filter\DateTimeType',
            'sonata_type_filter_datetime_range'            => 'Sonata\AdminBundle\Form\Type\Filter\DateTimeRangeType',
            'sonata_basket_basket'                         => 'Sonata\BasketBundle\Form\BasketType',
            'sonata_basker_address'                        => 'Sonata\BasketBundle\Form\Type\AddressType',
            'sonata_basket_shipping'                       => 'Sonata\BasketBundle\Form\ShippingType',
            'sonata_basket_payment'                        => 'Sonata\BasketBundle\Form\PaymentType',
            'sonata_basket_api_form_basket_parent'         => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_basket_api_form_basket'                => 'Sonata\BasketBundle\Form\ApiBasketType',
            'sonata_basket_api_form_basket_element_parent' => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_basket_api_form_basket_element'        => 'Sonata\BasketBundle\Form\ApiBasketElementType',
            'sonata_customer_address'                      => 'Sonata\CustomerBundle\Form\Type\AddressType',
            'sonata_customer_address_types'                => 'Sonata\CustomerBundle\Form\Type\AddressTypeType',
            'sonata_customer_api_form_customer'            => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_customer_api_form_address'             => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_delivery_choice'                       => 'Sonata\Component\Form\Type\DeliveryChoiceType',
            'sonata_invoice_status'                        => 'Sonata\InvoiceBundle\Form\Type\InvoiceStatusType',
            'sonata_order_status'                          => 'Sonata\OrderBundle\Form\Type\OrderStatusType',
            'sonata_payment_transaction_status'            => 'Sonata\PaymentBundle\Form\Type\PaymentTransactionStatusType',
            'sonata_product_delivery_status'               => 'Sonata\ProductBundle\Form\Type\ProductDeliveryStatusType',
            'sonata_product_variation_choices'             => 'Sonata\Component\Form\Type\VariationChoiceType',
            'sonata_product_api_form_product_parent'       => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_product_api_form_product'              => 'Sonata\ProductBundle\Form\Type\ApiProductType',
            'sonata_currency'                              => 'Sonata\Component\Currency\CurrencyFormType',
            'fos_comment_comment'                          => 'FOS\CommentBundle\Form\CommentType',
            'fos_comment_commentable_thread'               => 'FOS\CommentBundle\Form\CommentableThreadType',
            'fos_comment_delete_comment'                   => 'FOS\CommentBundle\Form\DeleteCommentType',
            'fos_comment_thread'                           => 'FOS\CommentBundle\Form\ThreadType',
            'fos_comment_vote'                             => 'FOS\CommentBundle\Form\VoteType',
            'sonata_comment_comment'                       => 'Sonata\CommentBundle\Form\Type\CommentType',
            'sonata_comment_status'                        => 'Sonata\CommentBundle\Form\Type\CommentStatusType',
            'sonata_type_immutable_array'                  => 'Sonata\CoreBundle\Form\Type\ImmutableArrayType',
            'sonata_type_boolean'                          => 'Sonata\CoreBundle\Form\Type\BooleanType',
            'sonata_type_collection'                       => 'Sonata\CoreBundle\Form\Type\CollectionType',
            'sonata_type_translatable_choice'              => 'Sonata\CoreBundle\Form\Type\TranslatableChoiceType',
            'sonata_type_date_range'                       => 'Sonata\CoreBundle\Form\Type\DateRangeType',
            'sonata_type_datetime_range'                   => 'Sonata\CoreBundle\Form\Type\DateTimeRangeType',
            'sonata_type_date_picker'                      => 'Sonata\CoreBundle\Form\Type\DatePickerType',
            'sonata_type_datetime_picker'                  => 'Sonata\CoreBundle\Form\Type\DateTimePickerType',
            'sonata_type_date_range_picker'                => 'Sonata\CoreBundle\Form\Type\DateRangePickerType',
            'sonata_type_datetime_range_picker'            => 'Sonata\CoreBundle\Form\Type\DateTimeRangePickerType',
            'sonata_type_equal'                            => 'Sonata\CoreBundle\Form\Type\EqualType',
            'sonata_type_color_selector'                   => 'Sonata\CoreBundle\Form\Type\ColorSelectorType',
            'sonata_formatter_type'                        => 'Sonata\FormatterBundle\Form\Type\FormatterType',
            'sonata_simple_formatter_type'                 => 'Sonata\FormatterBundle\Form\Type\SimpleFormatterType',
            'sonata_block_service_choice'                  => 'Sonata\BlockBundle\Form\Type\ServiceListType',
            'sonata_type_container_template_choice'        => 'Sonata\BlockBundle\Form\Type\ContainerTemplateType',
            'sonata_category_selector'                     => 'Sonata\ClassificationBundle\Form\Type\CategorySelectorType',
            'sonata_classification_api_form_category'      => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_classification_api_form_collection'    => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_classification_api_form_tag'           => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_classification_api_form_context'       => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'sonata_notification_api_form_message'         => 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType',
            'cmf_routing_route_type'                       => 'Symfony\Cmf\Bundle\RoutingBundle\Form\Type\RouteTypeType',
            'sonata_demo_form_type_car'                    => 'Sonata\Bundle\DemoBundle\Form\Type\CarType',
            'sonata_demo_form_type_engine'                 => 'Sonata\Bundle\DemoBundle\Form\Type\EngineType',
            'sonata_demo_form_type_newsletter'             => 'Sonata\Bundle\DemoBundle\Form\Type\NewsletterType',
            'tab'                                          => 'Mopa\Bundle\BootstrapBundle\Form\Type\TabType',
        );
    }

    /**
     * @param FormTypeInterface $type
     * @param OptionsResolver   $optionsResolver
     *
     * @internal
     */
    public static function configureOptions(FormTypeInterface $type, OptionsResolver $optionsResolver)
    {
        if (!method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            $type->setDefaultOptions($optionsResolver);
        } else {
            $type->configureOptions($optionsResolver);
        }
    }
}
