<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Entity;

use Sonata\CoreBundle\Entity\DoctrineBaseManager;

class BaseManager extends DoctrineBaseManager
{
}

class DoctrineBaseManagerTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();

        $manager = new BaseManager('classname', $entityManager);

        $this->assertEquals('classname', $manager->getClass());
    }
}
