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

namespace Sonata\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @author Hugo Briand <briand@ekino.com>
 * @author Titouan Galopin <galopintitouan@gmail.com>
 */
class StatusExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('sonata_status_class', [StatusRuntime::class, 'statusClass']),
        ];
    }

    public function getName()
    {
        return 'sonata_twig_status';
    }
}
