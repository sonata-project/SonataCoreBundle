<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\Extension;

@trigger_error(
    'The '.__NAMESPACE__.'\FlashMessageRuntime class is deprecated since version 3.x and will be removed in 4.0.'
    .' Use Sonata\Twig\Extension\FlashMessageRuntime instead.',
    E_USER_DEPRECATED
);

class_alias(
    \Sonata\Twig\Extension\FlashMessageRuntime::class,
    __NAMESPACE__.'\FlashMessageRuntime'
);
