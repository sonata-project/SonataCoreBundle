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

if (!class_exists(\Sonata\Twig\Extension\FlashMessageRuntime::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\FlashMessageRuntime class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\Extension\FlashMessageRuntime instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Twig\Extension\FlashMessageRuntime::class,
    __NAMESPACE__.'\FlashMessageRuntime'
);

if (false) {
    /**
     * This is the Sonata core flash message Twig runtime.
     *
     * @author Vincent Composieux <composieux@ekino.com>
     * @author Titouan Galopin <galopintitouan@gmail.com>
     *
     * @deprecated Since version 3.13.0, to be removed in 4.0.
     */
    final class FlashMessageRuntime extends \Sonata\Twig\Extension\FlashMessageRuntime
    {
    }
}
