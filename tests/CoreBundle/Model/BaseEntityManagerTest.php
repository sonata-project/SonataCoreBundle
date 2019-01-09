<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Entity;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Tests\Fixtures\Entity\EntityManager;

class BaseEntityManagerTest extends TestCase
{
    public function getManager()
    {
        $registry = $this->createMock(ManagerRegistry::class);

        $manager = new EntityManager('classname', $registry);

        return $manager;
    }

    /**
     * @group legacy
     */
    public function test()
    {
        $this->assertSame('classname', $this->getManager()->getClass());
    }

    /**
     * @group legacy
     */
    public function testException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The property exception does not exists');

        $this->getManager()->exception;
    }

    /**
     * @group legacy
     */
    public function testExceptionOnNonMappedEntity()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to find the mapping information for the class classname. Please check the `auto_mapping` option (http://symfony.com/doc/current/reference/configuration/doctrine.html#configuration-overview) or add the bundle to the `mappings` section in the doctrine configuration');

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $manager = new EntityManager('classname', $registry);
        $manager->getObjectManager();
    }

    /**
     * @group legacy
     */
    public function testGetEntityManager()
    {
        $objectManager = $this->createMock(ObjectManager::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($objectManager));

        $manager = new EntityManager('classname', $registry);

        $manager->em;
    }
}
