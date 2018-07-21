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

trait CommandManagerTrait
{
    public function save($entity, $andFlush = true)
    {
        $this->checkObject($entity);

        $this->getObjectManager()->persist($entity);

        if ($andFlush) {
            $this->getObjectManager()->flush();
        }
    }

    public function delete($entity, $andFlush = true)
    {
        $this->checkObject($entity);

        $this->getObjectManager()->remove($entity);

        if ($andFlush) {
            $this->getObjectManager()->flush();
        }
    }

    abstract public function getObjectManager();

    abstract public function getClass();

    /**
     * @throws \InvalidArgumentException
     */
    protected function checkObject($object)
    {
        $class = $this->getClass();

        if (!$object instanceof $class) {
            throw new \InvalidArgumentException(sprintf(
                'Object must be instance of %s, %s given',
                $class, is_object($object) ? get_class($object) : gettype($object)
            ));
        }
    }
}
