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

namespace Sonata\CoreBundle\Model\Adapter;

final class AdapterChain implements AdapterInterface
{
    private $adapters = [];

    public function addAdapter(AdapterInterface $adapter): void
    {
        $this->adapters[] = $adapter;
    }

    public function getNormalizedIdentifier($model): ?string
    {
        foreach ($this->adapters as $adapter) {
            $identifier = $adapter->getNormalizedIdentifier($model);

            if ($identifier) {
                return $identifier;
            }
        }

        return null;
    }

    public function getUrlsafeIdentifier($model): ?string
    {
        foreach ($this->adapters as $adapter) {
            $safeIdentifier = $adapter->getUrlsafeIdentifier($model);

            if ($safeIdentifier) {
                return $safeIdentifier;
            }
        }

        return null;
    }
}
