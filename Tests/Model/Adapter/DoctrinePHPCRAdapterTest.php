<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\DataTransformer;

use Doctrine\ODM\PHPCR\Mapping\ClassMetadata;
use Sonata\CoreBundle\Model\Adapter\DoctrinePHPCRAdapter;

class MyDocument
{
    public $path;
}

class DoctrinePHPCRAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \RunTimeException
     */
    public function testNormalizedIdentifierWithScalar()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $adapter = new DoctrinePHPCRAdapter($registry);

        $adapter->getNormalizedIdentifier(1);
    }

    public function testNormalizedIdentifierWithNull()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(null));
    }

    public function testNormalizedIdentifierWithNoManager()
    {
        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue(null));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    public function testNormalizedIdentifierWithNotManaged()
    {
        $unitOfWork = $this->getMockBuilder('Doctrine\ODM\PHPCR\UnitOfWork')->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->once())->method('getDocumentById')->will($this->returnValue(false));

        $manager = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')->disableOriginalConstructor()->getMock();
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));

        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $this->assertNull($adapter->getNormalizedIdentifier(new \stdClass()));
    }

    /**
     * @dataProvider getFixtures
     */
    public function testNormalizedIdentifierWithValidObject($data, $expected)
    {
        $unitOfWork = $this->getMockBuilder('Doctrine\ODM\PHPCR\UnitOfWork')->disableOriginalConstructor()->getMock();
        $unitOfWork->expects($this->any())->method('getDocumentById')->will($this->returnValue(true));

        $metadata = new ClassMetadata('Sonata\CoreBundle\Tests\Form\DataTransformer\MyDocument');
        $metadata->identifier = 'path';
        $metadata->reflFields['path'] = new \ReflectionProperty('Sonata\CoreBundle\Tests\Form\DataTransformer\MyDocument', 'path');

        $manager = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')->disableOriginalConstructor()->getMock();
        $manager->expects($this->any())->method('getUnitOfWork')->will($this->returnValue($unitOfWork));
        $manager->expects($this->any())->method('getClassMetadata')->will($this->returnValue($metadata));

        $registry = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->any())->method('getManagerForClass')->will($this->returnValue($manager));

        $adapter = new DoctrinePHPCRAdapter($registry);

        $instance = new MyDocument();
        $instance->path = $data;

        $this->assertEquals($data, $adapter->getNormalizedIdentifier($instance));
        $this->assertEquals($expected, $adapter->getUrlsafeIdentifier($instance));
    }

    public static function getFixtures()
    {
        return array(
            array("/salut", "salut"),
            array("/les-gens", "les-gens"),
        );
    }
}