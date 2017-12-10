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

use Sonata\CoreBundle\Component\Status\StatusClassRendererInterface;
use Twig\Extension\AbstractExtension;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class StatusExtension extends AbstractExtension
{
    /**
     * @var StatusClassRendererInterface[]
     */
    protected $statusServices = [];

    /**
     * Adds a renderer to the status services list.
     *
     * @param StatusClassRendererInterface $renderer
     */
    public function addStatusService(StatusClassRendererInterface $renderer)
    {
        $this->statusServices[] = $renderer;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('sonata_status_class', [$this, 'statusClass']),
        ];
    }

    /**
     * @param mixed  $object
     * @param mixed  $statusType
     * @param string $default
     *
     * @return string
     */
    public function statusClass($object, $statusType = null, $default = '')
    {
        /** @var StatusClassRendererInterface $statusService */
        foreach ($this->statusServices as $statusService) {
            if ($statusService->handlesObject($object, $statusType)) {
                return $statusService->getStatusClass($object, $statusType, $default);
            }
        }

        return $default;
    }

    public function getName()
    {
        return 'sonata_core_status';
    }
}
