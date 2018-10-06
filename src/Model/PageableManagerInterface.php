<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Model;

@trigger_error(
    'The '.__NAMESPACE__.'\PageableManagerInterface class is deprecated since version 3.x and will be removed in 4.0.'
    .' Use Sonata\DatagridBundle\Pager\PageableInterface instead.',
    E_USER_DEPRECATED
);

/**
 * @author Raphaël Benitte <benitteraphael@gmail.com>
 *
 * @deprecated since 3.x, to be removed in 4.0.
 */
interface PageableManagerInterface extends \Sonata\Doctrine\Model\PageableManagerInterface
{
}
