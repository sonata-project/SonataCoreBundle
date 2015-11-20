<?php

/*
 * This file is part of the NelmioApiDocBundle.
 *
 * (c) Nelmio <hello@nelm.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Util;

/**
 * Extracted from FOSUserBundle.
 *
 * @internal
 */
final class LegacyFormHelper
{
    private static $map = array(
        'Symfony\Component\Form\Extension\Core\Type\DateTimeType' => 'datetime',
        'Symfony\Component\Form\Extension\Core\Type\DateType'     => 'date',
        'Symfony\Component\Form\Extension\Core\Type\ChoiceType'   => 'choice',
    );

    public static function getType($class)
    {
        if (!self::isLegacy()) {
            return $class;
        }
        if (!isset(self::$map[$class])) {
            throw new \InvalidArgumentException(sprintf('Form type with class "%s" can not be found. Please check for typos or add it to the map in LegacyFormHelper', $class));
        }

        return self::$map[$class];
    }

    public static function isLegacy()
    {
        return !method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
