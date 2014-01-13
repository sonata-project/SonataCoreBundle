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

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Model\ManagerInterface;

/**
 * Class BaseManager.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class DoctrineBaseManager implements ManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param string        $class
     * @param EntityManager $em
     */
    public function __construct($class, EntityManager $em)
    {
        $this->em    = $em;
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
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($entity, $andFlush = true)
    {
        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->em->getClassMetadata($this->class)->table['name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        return $this->em->getConnection();
    }

    /**
     * Return the related Entity Repository.
     *
     * @return EntityRepository
     */
    protected function getRepository()
    {
        if (!$this->repository) {
            $this->repository = $this->em->getRepository($this->class);
        }

        return $this->repository;
    }
}
