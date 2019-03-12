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

if (!interface_exists(\Sonata\Doctrine\Model\PageableManagerInterface::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\PageableManagerInterface class is deprecated since version 3.12.0 and will be removed in 4.0.'
        .' Use Sonata\DatagridBundle\Pager\PageableInterface instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Model\PageableManagerInterface::class,
    __NAMESPACE__.'\PageableManagerInterface'
);

if (false) {
    interface PageableManagerInterface extends \Sonata\Doctrine\Model\PageableManagerInterface
    {
    }
}
