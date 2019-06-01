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
    public function setUp()
    {
        if (!class_exists(UnitOfWork::class)) {
            $this->markTestSkipped('Doctrine PHPCR not installed');
        }
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithScalar()
    {
        $this->expectException(\RuntimeException::class);

        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrinePHPCRAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNull()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNoManager()
    {
        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->willReturn(null);

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @group legacy
     */
    public function testNormalizedIdentifierWithNotManaged()
    {
        $manager = $this->getMockBuilder(DocumentManager::class)->disableOriginalConstructor()->getMock();
        $manager->expects($this->once())->method('contains')->willReturn(false);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->once())->method('getManagerForClass')->willReturn($manager);

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     *
     * @group legacy
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected)
    {
        $metadata = new ClassMetadata(MyDocument::class);
        $metadata->identifier = 'path';
        $metadata->reflFields['path'] = new \ReflectionProperty(MyDocument::class, 'path');

        $manager = $this->getMockBuilder(DocumentManager::class)->disableOriginalConstructor()->getMock();
        $manager->expects($this->any())->method('contains')->willReturn(true);
        $manager->expects($this->any())->method('getClassMetadata')->willReturn($metadata);

        $registry = $this->createMock(ManagerRegistry::class);
        $registry->expects($this->any())->method('getManagerForClass')->willReturn($manager);

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
