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

use Sonata\CoreBundle\FlashMessage\FlashManager;

/**
 * This is the Sonata core flash message Twig runtime.
 *
 * @author Vincent Composieux <composieux@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class FlashMessageRuntime
{
    private $flashManager;

    public function __construct(FlashManager $flashManager)
    {
        $this->flashManager = $flashManager;
    }

    /**
     * Returns flash messages handled by Sonata core flash manager.
     *
     * @param string $type   Type of flash message
     * @param string $domain Translation domain to use
     *
     * @return string
     */
    public function getFlashMessages($type, $domain = null)
    {
        return $this->flashManager->get($type, $domain);
    }

    /**
     * Returns flash messages types handled by Sonata core flash manager.
     *
     * @return string
     */
    public function getFlashMessagesTypes()
    {
        return $this->flashManager->getHandledTypes();
    }
}
