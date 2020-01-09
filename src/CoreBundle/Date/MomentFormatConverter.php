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

namespace Sonata\CoreBundle\Date;

if (!class_exists(\Sonata\Form\Date\MomentFormatConverter::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\MomentFormatConverter class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Form\Date\MomentFormatConverter instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Form\Date\MomentFormatConverter::class,
    __NAMESPACE__.'\MomentFormatConverter'
);

if (false) {
    /**
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    class MomentFormatConverter extends \Sonata\Form\Date\MomentFormatConverter
    {
    }
}
