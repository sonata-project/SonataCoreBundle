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

namespace Sonata\CoreBundle\Tests\Model\Adapter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Model\Adapter\DoctrineORMAdapter;

class DoctrineORMAdapterTest extends TestCase
{
    public function setUp()
    {
        if (!class_exists(UnitOfWork::class)) {
            $this->markTestSkipped('Doctrine ORM not installed');
        }
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithScalar()
    {
        $this->expectException(\RuntimeException::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrineORMAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNull()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNoManager()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->willReturn(null);

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNotManaged()
    {
        $unitOfWork = $this->getMockBuilder(UnitOfWork::class)->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->willReturn(false);

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager->expects($this->any())->method('getUnitOfWork')->willReturn($unitOfWork);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->willReturn($manager);

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     *
     * @group legacy
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected)
    {
        $unitOfWork = $this->getMockBuilder(UnitOfWork::class)->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->willReturn(true);
        $unitOfWork->expects($this->once())->method('getEntityIdentifier')->willReturn($data);

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager->expects($this->any())->method('getUnitOfWork')->willReturn($unitOfWork);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->willReturn($manager);

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertSame($expected, $adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public static function getFixtures()
    {
        return [
            [[1], '1'],
            [[1, 2], '1~2'],
        ];
    }
}
