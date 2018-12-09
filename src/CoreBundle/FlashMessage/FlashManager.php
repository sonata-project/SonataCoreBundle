<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\FlashMessage;

@trigger_error(
    'The '.__NAMESPACE__.'\FlashManager class is deprecated since version 3.x and will be removed in 4.0.'
    .' Use Sonata\Twig\FlashMessage\FlashManager instead.',
    E_USER_DEPRECATED
);

/**
 * @author Vincent Composieux <composieux@ekino.com>
 *
 * @deprecated Since version 3.x, to be removed in 4.0.
 */
class FlashManager extends \Sonata\Twig\FlashMessage\FlashManager
{
}
