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

namespace Sonata\CoreBundle\Component\Status;

if (!interface_exists('\Sonata\Twig\Status\StatusClassRendererInterface', false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\StatusClassRendererInterface class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\Status\StatusClassRendererInterface instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    '\Sonata\Twig\Status\StatusClassRendererInterface',
    '\Sonata\CoreBundle\Component\Status\StatusClassRendererInterface'
);

if (false) {
    /**
     * @author Hugo Briand <briand@ekino.com>
     *
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    interface StatusClassRendererInterface extends \Sonata\Twig\Status\StatusClassRendererInterface
    {
    }
}
