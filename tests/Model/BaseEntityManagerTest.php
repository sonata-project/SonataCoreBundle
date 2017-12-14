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
use Sonata\CoreBundle\Model\BaseEntityManager;

class EntityManager extends BaseEntityManager
{
}

class BaseEntityManagerTest extends TestCase
{
    public function getManager()
    {
        $registry = $this->createMock(ManagerRegistry::class);

        $manager = new EntityManager('classname', $registry);

        return $manager;
    }

    public function test(): void
    {
        $this->assertSame('classname', $this->getManager()->getClass());
    }

    public function testException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The property exception does not exists');

        $this->getManager()->exception;
    }

    public function testExceptionOnNonMappedEntity(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to find the mapping information for the class classname. Please check the `auto_mapping` option (http://symfony.com/doc/current/reference/configuration/doctrine.html#configuration-overview) or add the bundle to the `mappings` section in the doctrine configuration');

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $manager = new EntityManager('classname', $registry);
        $manager->getObjectManager();
    }

    public function testGetEntityManager(): void
    {
        $objectManager = $this->createMock(ObjectManager::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($objectManager));

        $manager = new EntityManager('classname', $registry);

        $manager->em;
    }
}
