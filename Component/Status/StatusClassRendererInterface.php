<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Component\Status;

/**
 * Class StatusClassRendererInterface
 *
 * @author Hugo Briand <briand@ekino.com>
 */
interface StatusClassRendererInterface
{
    /**
     * Tells if class may handle $object for status class rendering
     *
     * @param mixed $object
     * @param mixed $statusType
     *
     * @return bool
     */
    public function handlesObject($object, $statusType = null);

    /**
     * Returns the status CSS class for $object
     *
     * @param mixed  $object
     * @param mixed  $statusType
     * @param string $default
     *
     * @return string
     */
    public function getStatusClass($object, $statusType = null, $default = "");
}