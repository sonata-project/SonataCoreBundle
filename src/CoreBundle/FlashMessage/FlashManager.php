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

namespace Sonata\CoreBundle\FlashMessage;

if (!class_exists(\Sonata\Twig\FlashMessage\FlashManager::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\FlashManager class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\FlashMessage\FlashManager instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Twig\FlashMessage\FlashManager::class,
    __NAMESPACE__.'\FlashManager'
);

if (false) {
    /**
     * @author Vincent Composieux <composieux@ekino.com>
     *
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    class FlashManager extends \Sonata\Twig\FlashMessage\FlashManager
    {
    }
}
