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

if (!class_exists(\Sonata\Doctrine\Adapter\AdapterChain::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\AdapterChain class is deprecated since version 3.12.0 and will be removed in 4.0.'
        .' Use Sonata\Doctrine\Adapter\AdapterChain instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Adapter\AdapterChain::class,
    __NAMESPACE__.'\AdapterChain'
);

if (false) {
    /**
     * @deprecated since sonata-project/core-bundle 3.12.0, to be removed in 4.0.
     */
    class AdapterChain extends \Sonata\Doctrine\Adapter\AdapterChain implements AdapterInterface
    {
    }
}
