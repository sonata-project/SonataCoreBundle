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
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * This is the Sonata core flash message Twig extension.
 *
 * @author Vincent Composieux <composieux@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class FlashMessageExtension extends AbstractExtension
{
    /**
     * @var FlashManager
     */
    protected $flashManager;

    public function __construct(FlashManager $flashManager = null)
    {
        $this->flashManager = $flashManager;

        if ($this->flashManager) {
            @trigger_error(
                'Argument "flashManager" in FlashMessageExtension is deprecated since SonataCoreBundle 3.x and will'.
                ' be removed in 4.0. Use the FlashMessageRuntime instead.',
                E_USER_DEPRECATED
            );
        }
    }

    public function getFunctions()
    {
        if ($this->flashManager) {
            return [
                new TwigFunction('sonata_flashmessages_get', [$this, 'getFlashMessages']),
                new TwigFunction('sonata_flashmessages_types', [$this, 'getFlashMessagesTypes']),
            ];
        }

        return [
            new TwigFunction('sonata_flashmessages_get', [FlashMessageRuntime::class, 'getFlashMessages']),
            new TwigFunction('sonata_flashmessages_types', [FlashMessageRuntime::class, 'getFlashMessagesTypes']),
        ];
    }

    /**
     * Returns flash messages handled by Sonata core flash manager.
     *
     * @param string $type   Type of flash message
     * @param string $domain Translation domain to use
     *
     * @return string
     *
     * @deprecated since 3.x, to be removed in 4.0. Use the FlashMessageRuntime instead.
     */
    public function getFlashMessages($type, $domain = null)
    {
        @trigger_error(
            'Method "FlashMessageExtension::getFlashMessages()" is deprecated since SonataCoreBundle 3.x and will'.
            ' be removed in 4.0. Use the FlashMessageRuntime instead.',
            E_USER_DEPRECATED
        );

        return $this->flashManager->get($type, $domain);
    }

    /**
     * Returns flash messages types handled by Sonata core flash manager.
     *
     * @return string
     *
     * @deprecated since 3.x, to be removed in 4.0. Use the FlashMessageRuntime instead.
     */
    public function getFlashMessagesTypes()
    {
        @trigger_error(
            'Method "FlashMessageExtension::getFlashMessagesTypes()" is deprecated since SonataCoreBundle 3.x and will'.
            ' be removed in 4.0. Use the FlashMessageRuntime instead.',
            E_USER_DEPRECATED
        );

        return $this->flashManager->getHandledTypes();
    }

    public function getName()
    {
        return 'sonata_core_flashmessage';
    }
}
