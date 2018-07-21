<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Model;

interface CommandManagerInterface
{
    /**
     * Save an Entity.
     *
     * @param object $entity   The Entity to save
     * @param bool   $andFlush Flush the EntityManager after saving the object?
     */
    public function save($entity, $andFlush = true);

    /**
     * Delete an Entity.
     *
     * @param object $entity   The Entity to delete
     * @param bool   $andFlush Flush the EntityManager after deleting the object?
     */
    public function delete($entity, $andFlush = true);
}
