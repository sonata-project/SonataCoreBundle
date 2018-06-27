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
 * @author Titouan Galopin <galopintitouan@gmail.com>
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
     *
     * @deprecated since 3.x, to be removed in 4.0. Use the StatusRuntime instead.
     */
    public function addStatusService(StatusClassRendererInterface $renderer)
    {
        @trigger_error(
            'Method "StatusExtension::addStatusService()" is deprecated since SonataCoreBundle 3.x and will'.
            ' be removed in 4.0. Use the StatusRuntime instead.',
            E_USER_DEPRECATED
        );

        $this->statusServices[] = $renderer;
    }

    public function getFilters()
    {
        if (!empty($this->statusServices)) {
            return [
                new \Twig_SimpleFilter('sonata_status_class', [$this, 'statusClass']),
            ];
        }

        return [
            new \Twig_SimpleFilter('sonata_status_class', [StatusRuntime::class, 'statusClass']),
        ];
    }

    /**
     * @param mixed  $object
     * @param mixed  $statusType
     * @param string $default
     *
     * @return string
     *
     * @deprecated since 3.x, to be removed in 4.0. Use the StatusRuntime instead.
     */
    public function statusClass($object, $statusType = null, $default = '')
    {
        @trigger_error(
            'Method "StatusExtension::statusClass()" is deprecated since SonataCoreBundle 3.x and will'.
            ' be removed in 4.0. Use the StatusRuntime instead.',
            E_USER_DEPRECATED
        );

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
