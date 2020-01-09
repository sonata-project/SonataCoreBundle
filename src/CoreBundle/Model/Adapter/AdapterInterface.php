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

namespace Sonata\CoreBundle\Model\Adapter;

if (!interface_exists(\Sonata\Doctrine\Adapter\AdapterInterface::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\AdapterInterface class is deprecated since version 3.12.0 and will be removed in 4.0.'
        .' Use Sonata\Doctrine\Adapter\AdapterInterface instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Adapter\AdapterInterface::class,
    __NAMESPACE__.'\AdapterInterface'
);

if (false) {
    /**
     * @deprecated since sonata-project/core-bundle 3.12.0, to be removed in 4.0.
     */
    interface AdapterInterface extends \Sonata\Doctrine\Adapter\AdapterInterface
    {
    }
}
