<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;


/**
 * Class BaseManager
 *
 * @package Sonata\CoreBundle\Entity
 *
 * @author  Hugo Briand <briand@ekino.com>
 */
abstract class BaseManager implements ManagerInterface
{
    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param string        $class
     * @param ObjectManager $om
     */
    public function __construct($class, ObjectManager $om)
    {
        $this->om    = $om;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return new $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function save($entity, $andFlush = true)
    {
        $this->om->persist($entity);

        if ($andFlush) {
            $this->om->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity, $andFlush = true)
    {
        $this->om->remove($entity);

        if ($andFlush) {
            $this->om->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->om->getClassMetadata($this->class)->table['name'];
    }

    /**
     * Returns the related Object Repository.
     *
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->om->getRepository($this->class);
        }

        return $this->repository;
    }
}
