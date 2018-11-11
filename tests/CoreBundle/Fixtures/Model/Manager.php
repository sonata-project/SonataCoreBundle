<?php

namespace Sonata\CoreBundle\Tests\Fixtures\Model;

use Sonata\CoreBundle\Model\BaseManager;

class Manager extends BaseManager
{
    /**
     * Get the DB driver connection.
     *
     * @return Connection
     */
    public function getConnection()
    {
    }

    /**
     * @param $object
     */
    public function publicCheckObject($object)
    {
        return $this->checkObject($object);
    }
}
