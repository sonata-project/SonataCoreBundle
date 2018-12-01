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

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * This is the Sonata core flash message Twig extension.
 *
 * @author Vincent Composieux <composieux@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
final class FlashMessageExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sonata_flashmessages_get', [FlashMessageRuntime::class, 'getFlashMessages']),
            new TwigFunction('sonata_flashmessages_types', [FlashMessageRuntime::class, 'getFlashMessagesTypes']),
        ];
    }

    public function getName(): string
    {
        return 'sonata_core_flashmessage';
    }
}
