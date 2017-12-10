<?php

/*
 * This file is part of the Sonata Project package.
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
    private static $typeMapping = [];

    private static $extensionMapping = [];

    /**
     * This function remove fields available if there are not present in the $data array
     * The data array might come from $request->request->all().
     *
     * This can be usefull if you don't want to send all fields will building an api. As missing
     * fields will be threated like null values.
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
        return self::$extensionMapping;
    }

    public static function registerFormTypeMapping(array $mapping)
    {
        self::$typeMapping = array_merge(self::$typeMapping, $mapping);
    }

    /**
     * @param string $type
     */
    public static function registerFormExtensionMapping($type, array $services)
    {
        if (!isset(self::$extensionMapping[$type])) {
            self::$extensionMapping[$type] = [];
        }

        self::$extensionMapping[$type] = array_merge(self::$extensionMapping[$type], $services);
    }

    /**
     * @return array
     */
    public static function getFormTypeMapping()
    {
        return self::$typeMapping;
    }

    /**
     * @internal
     */
    public static function configureOptions(FormTypeInterface $type, OptionsResolver $optionsResolver)
    {
        $type->configureOptions($optionsResolver);
    }
}
