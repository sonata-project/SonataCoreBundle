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
    /**
     * @var FlashManager
     */
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
     */
    public function getFlashMessages(string $type, string $domain = null): array
    {
        return $this->flashManager->get($type, $domain);
    }

    /**
     * Returns flash messages types handled by Sonata core flash manager.
     */
    public function getFlashMessagesTypes(): array
    {
        return $this->flashManager->getHandledTypes();
    }
}
