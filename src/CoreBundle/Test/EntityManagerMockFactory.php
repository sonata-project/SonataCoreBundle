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

if (!class_exists(\Sonata\Doctrine\Test\EntityManagerMockFactory::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\EntityManagerMockFactory class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Doctrine\Test\EntityManagerMockFactory instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Test\EntityManagerMockFactory::class,
    __NAMESPACE__.'\EntityManagerMockFactory'
);

if (false) {
    /**
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    class EntityManagerMockFactory extends \Sonata\Doctrine\Test\EntityManagerMockFactory
    {
    }
}
