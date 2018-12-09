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
    'The '.__NAMESPACE__.'\StatusRuntime class is deprecated since version 3.x and will be removed in 4.0.'
    .' Use Sonata\Twig\Extension\StatusRuntime instead.',
    E_USER_DEPRECATED
);

/**
 * @author Hugo Briand <briand@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @deprecated Since version 3.x, to be removed in 4.0.
 */
final class StatusRuntime extends \Sonata\Twig\Extension\StatusRuntime
{
}
