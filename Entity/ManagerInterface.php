<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class BaseManager.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
interface ManagerInterface
{
    /**
     * Set the Entity class name.
     *
     * @param string $class
     */
    public function setClass($class);

    /**
     * Return the Entity class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Find all entities in the repository.
     *
     * @return array
     */
    public function findAll();

    /**
     * Find entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Find a single entity by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * Create an empty Entity instance.
     *
     * @return object
     */
    public function create();

    /**
     * Save an Entity.
     *
     * @param object  $entity   The Entity to save
     * @param boolean $andFlush Flush the EntityManager after saving the object?
     */
    public function save($entity, $andFlush = true);

    /**
     * Delete an Entity.
     *
     * @param object  $entity   The Entity to delete
     * @param boolean $andFlush Flush the EntityManager after deleting the object?
     */
    public function delete($entity, $andFlush = true);

    /**
     * Get the related table name.
     *
     * @return string
     */
    public function getTableName();
}
