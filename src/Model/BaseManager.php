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

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
abstract class BaseManager implements ManagerInterface
{
    use CommandManagerTrait, QueryManagerTrait;

    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @var string
     */
    protected $class;

    /**
     * @param string          $class
     * @param ManagerRegistry $registry
     */
    public function __construct($class, ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->class = $class;
    }

    /**
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        $manager = $this->registry->getManagerForClass($this->class);

        if (!$manager) {
            throw new \RuntimeException(sprintf(
                'Unable to find the mapping information for the class %s.'
                .' Please check the `auto_mapping` option'
                .' (http://symfony.com/doc/current/reference/configuration/doctrine.html#configuration-overview)'
                .' or add the bundle to the `mappings` section in the doctrine configuration.',
                $this->class
            ));
        }

        return $manager;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function create()
    {
        return new $this->class();
    }

    public function getTableName()
    {
        return $this->getObjectManager()->getClassMetadata($this->class)->table['name'];
    }

    /**
     * Returns the related Object Repository.
     *
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->class);
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkObject($object)
    {
        if (!$object instanceof $this->class) {
            throw new \InvalidArgumentException(sprintf(
                'Object must be instance of %s, %s given',
                $this->class, is_object($object) ? get_class($object) : gettype($object)
            ));
        }
    }
}
