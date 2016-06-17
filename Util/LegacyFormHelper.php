<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Util;

/**
 * Helper class to handle the different behaviour of the corresponding symfony versions.
 *
 * @author Christian Gripp <mail@core23.de>
 *
 * @internal You shouldn't rely on this class when supporting only symfony >=2.8.
 */
final class LegacyFormHelper
{
    /**
     * Detects if you are using an old symfony (<2.8) version.
     *
     * @return bool
     */
    public static function isLegacy()
    {
        return !self::isModern();
    }

    /**
     * Detects if you are using a new (>=2.8) symfony version.
     *
     * @return bool
     */
    public static function isModern()
    {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }

    /**
     * Returns the correct form name according to your symfony version.
     *
     * @param string $className
     * @param string $formName
     *
     * @return string
     */
    public static function getType($className, $formName)
    {
        return self::isModern() ? $className : $formName;
    }

    /**
     * Flipps the choice options if you are using a new symfony version.
     *
     * @param array $options
     */
    public static function fixChoiceOptions(&$options)
    {
        if (method_exists('Symfony\Component\Form\AbstractType', 'configureOptions')) {
            $options['choices'] = array_flip($options['choices']);

            // choice_as_value options is not needed in SF 3.0+
            if (method_exists('Symfony\Component\Form\FormTypeInterface', 'setDefaultOptions')) {
                $options['choices_as_values'] = true;
            }
        }
    }
}
