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

use Doctrine\DBAL\Connection;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
interface ManagerInterface extends CommandManagerInterface, QueryManagerInterface
{
    /**
     * Create an empty Entity instance.
     *
     * @return object
     */
    public function create();

    /**
     * Return the Entity class name.
     *
     * @return string
     */
    public function getClass();

    /**
     * Get the related table name.
     *
     * @return string
     */
    public function getTableName();

    /**
     * Get the DB driver connection.
     *
     * @return Connection
     */
    public function getConnection();
}
