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

namespace Sonata\CoreBundle\Test;

if (!class_exists(\Sonata\Form\Test\AbstractWidgetTestCase::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\AbstractWidgetTestCase class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Form\Test\AbstractWidgetTestCase instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Form\Test\AbstractWidgetTestCase::class,
    __NAMESPACE__.'\AbstractWidgetTestCase'
);

if (false) {
    /**
     * @deprecated Since version 3.13.0, to be removed in 4.0.
     */
    abstract class AbstractWidgetTestCase extends \Sonata\Form\Test\AbstractWidgetTestCase
    {
    }
}
