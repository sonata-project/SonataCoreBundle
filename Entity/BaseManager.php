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

/**
 * Class BaseManager.
 *
 * @author Sylvain Deloux <sylvain.deloux@fullsix.com>
 */
abstract class BaseManager implements BaseManagerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

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

        $this->repository = $this->em->getRepository($this->class);
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
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritdoc}
     */
    public function doCreate()
    {
        return new $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function doSave($entity, $andFlush = true)
    {
        $this->em->persist($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function doDelete($entity, $andFlush = true)
    {
        $this->em->remove($entity);

        if ($andFlush) {
            $this->em->flush();
        }
    }
}
