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
use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;
use Doctrine\ODM\PHPCR\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Model\Adapter\DoctrinePHPCRAdapter;

class MyDocument
{
    public $path;
}

class DoctrinePHPCRAdapterTest extends TestCase
{
    public function setUp(): void
    {
        if (!class_exists(UnitOfWork::class)) {
            $this->markTestSkipped('Doctrine PHPCR not installed');
        }
    }

    public function testNormalizedIdentifierWithScalar(): void
    {
        $this->expectException(\RuntimeException::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrinePHPCRAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    public function testNormalizedIdentifierWithNull(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    public function testNormalizedIdentifierWithNoManager(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public function testNormalizedIdentifierWithNotManaged(): void
    {
        $manager = $this->createMock(DocumentManager::class);
        $manager->expects($this->once())->method('contains')->will($this->returnValue(false));

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected): void
    {
        $metadata = new ClassMetadata(MyDocument::class);
        $metadata->identifier = 'path';
        $metadata->reflFields['path'] = new \ReflectionProperty(MyDocument::class, 'path');

        $manager = $this->createMock(DocumentManager::class);
        $manager->expects($this->any())->method('contains')->will($this->returnValue(true));
        $manager->expects($this->any())->method('getClassMetadata')->will($this->returnValue($metadata));

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->any())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $instance = new MyDocument();
        $instance->path = $data;

        $this->assertSame($data, $adapter->getNormalizedIdentifier($instance));
        $this->assertSame($expected, $adapter->getUrlsafeIdentifier($instance));
    }

    public static function getFixtures()
    {
        return [
            ['/salut', 'salut'],
            ['/les-gens', 'les-gens'],
        ];
    }
}
