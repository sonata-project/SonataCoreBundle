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

namespace Sonata\CoreBundle\Model;

if (!interface_exists(\Sonata\Doctrine\Model\ManagerInterface::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\ManagerInterface class is deprecated since version 3.12.0 and will be removed in 4.0.'
        .' Use Sonata\Doctrine\Model\ManagerInterface instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Model\ManagerInterface::class,
    __NAMESPACE__.'\ManagerInterface'
);

if (false) {
    /**
     * @author Sylvain Deloux <sylvain.deloux@ekino.com>
     *
     * @deprecated since sonata-project/core-bundle 3.12.0, to be removed in 4.0.
     */
    interface ManagerInterface extends \Sonata\Doctrine\Model\ManagerInterface
    {
    }
}
