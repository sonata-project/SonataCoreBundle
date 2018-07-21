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

interface QueryManagerInterface
{
    /**
     * Find all entities in the repository.
     *
     * @return array
     */
    public function findAll();

    /**
     * Find entities by a set of criteria.
     *
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Find a single entity by a set of criteria.
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed $id The identifier
     *
     * @return object
     */
    public function find($id);
}
