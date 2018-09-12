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
    public function setUp(): void
    {
        if (!class_exists(UnitOfWork::class)) {
            $this->markTestSkipped('Doctrine ORM not installed');
        }
    }

    public function testNormalizedIdentifierWithScalar(): void
    {
        $this->expectException(\RuntimeException::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrineORMAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    public function testNormalizedIdentifierWithNull(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    public function testNormalizedIdentifierWithNoManager(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public function testNormalizedIdentifierWithNotManaged(): void
    {
        $unitOfWork = $this->createMock(UnitOfWork::class);
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->will($this->returnValue(false));

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected): void
    {
        $unitOfWork = $this->createMock(UnitOfWork::class);
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->will($this->returnValue(true));
        $unitOfWork->expects($this->once())->method('getEntityIdentifier')->will($this->returnValue($data));

        $manager = $this->createMock(EntityManagerInterface::class);
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

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
