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
use Twig\TwigFunction;

@trigger_error(
    'The '.__NAMESPACE__.'\FlashMessageExtension class is deprecated since version 3.13.0 and will be removed in 4.0.'
    .' Use Sonata\Twig\Extension\FlashMessageExtension instead.',
    E_USER_DEPRECATED
);

/**
 * This is the Sonata core flash message Twig extension.
 *
 * @author Vincent Composieux <composieux@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 *
 * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
 */
class FlashMessageExtension extends \Sonata\Twig\Extension\FlashMessageExtension
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
                'Argument "flashManager" in FlashMessageExtension is deprecated since SonataCoreBundle 3.11.0 and will'.
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

        return parent::getFunctions();
    }

    /**
     * Returns flash messages handled by Sonata core flash manager.
     *
     * @param string $type   Type of flash message
     * @param string $domain Translation domain to use
     *
     * @return string
     *
     * @deprecated since sonata-project/core-bundle 3.11.0, to be removed in 4.0. Use the FlashMessageRuntime instead.
     */
    public function getFlashMessages($type, $domain = null)
    {
        @trigger_error(
            'Method "FlashMessageExtension::getFlashMessages()" is deprecated since SonataCoreBundle 3.11.0 and will'.
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
     * @deprecated since sonata-project/core-bundle 3.11.0, to be removed in 4.0. Use the FlashMessageRuntime instead.
     */
    public function getFlashMessagesTypes()
    {
        @trigger_error(
            'Method "FlashMessageExtension::getFlashMessagesTypes()" is deprecated since SonataCoreBundle 3.11.0 and will'.
            ' be removed in 4.0. Use the FlashMessageRuntime instead.',
            E_USER_DEPRECATED
        );

        return $this->flashManager->getHandledTypes();
    }
}
