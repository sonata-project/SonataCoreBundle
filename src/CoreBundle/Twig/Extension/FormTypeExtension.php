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

namespace Sonata\CoreBundle\Twig\Extension;

if (!class_exists(\Sonata\Twig\Extension\FormTypeExtension::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\FormTypeExtension class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\Extension\FormTypeExtension instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Twig\Extension\FormTypeExtension::class,
    __NAMESPACE__.'\FormTypeExtension'
);

if (false) {
    /**
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    class FormTypeExtension extends \Sonata\Twig\Extension\FormTypeExtension
    {
    }
}
