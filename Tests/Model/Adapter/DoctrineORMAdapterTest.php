<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Model\Adapter;

use Sonata\CoreBundle\Model\Adapter\DoctrineORMAdapter;
use Sonata\CoreBundle\Tests\PHPUnit_Framework_TestCase;

class DoctrineORMAdapterTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('Doctrine\ORM\UnitOfWork')) {
            $this->markTestSkipped('Doctrine ORM not installed');
        }
    }

    /**
     * @expectedException \RunTimeException
     */
    public function testNormalizedIdentifierWithScalar()
    {
        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $adapter = new DoctrineORMAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    public function testNormalizedIdentifierWithNull()
    {
        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    public function testNormalizedIdentifierWithNoManager()
    {
        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public function testNormalizedIdentifierWithNotManaged()
    {
        $unitOfWork = $this->getMockBuilder('Doctrine\ORM\UnitOfWork')->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->will($this->returnValue(false));

        $manager = $this->createMock('Doctrine\ORM\EntityManagerInterface');
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));

        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected)
    {
        $unitOfWork = $this->getMockBuilder('Doctrine\ORM\UnitOfWork')->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->once())->method('isInIdentityMap')->will($this->returnValue(true));
        $unitOfWork->expects($this->once())->method('getEntityIdentifier')->will($this->returnValue($data));

        $manager = $this->createMock('Doctrine\ORM\EntityManagerInterface');
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));

        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrineORMAdapter($registry);

        $this->assertSame($expected, $adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public static function getFixtures()
    {
        return array(
            array(array(1), '1'),
            array(array(1, 2), '1~2'),
        );
    }
}
