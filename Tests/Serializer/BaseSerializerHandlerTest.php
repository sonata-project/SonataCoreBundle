<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Serializer;

use JMS\Serializer\GraphNavigator;
use Sonata\CoreBundle\Tests\Fixtures\Bundle\Serializer\FooSerializer;
use Sonata\CoreBundle\Tests\PHPUnit_Framework_TestCase;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class BaseSerializerHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testSetFormats()
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');

        $serializer = new FooSerializer($manager);

        $expectedMethods = array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ),
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ),
        );

        $serializer::setFormats(array('bar'));

        $methods = $serializer::getSubscribingMethods();

        $this->assertSame($methods, $expectedMethods);
    }

    public function testAddFormats()
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');

        $serializer = new FooSerializer($manager);

        $expectedMethods = array(
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ),
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ),
            array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'foo',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ),
            array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'foo',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ),
        );

        $serializer::setFormats(array('bar'));

        $serializer::addFormat('foo');

        $methods = $serializer::getSubscribingMethods();

        $this->assertSame($methods, $expectedMethods);
    }

    public function testSerializeObjectToIdWithDataIsInstanceOfManager()
    {
        $modelInstance = $this->getMockBuilder('Sonata\CoreBundle\Tests\Fixtures\Bundle\Serializer\FooSerializer')
            ->disableOriginalConstructor()
            ->setMethods(array('getId'))
            ->getMock();

        $modelInstance->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');
        $manager->expects($this->once())
            ->method('getClass')
            ->willReturn(get_class($modelInstance));

        $context = $this->createMock('JMS\Serializer\Context');

        $visitor = $this->createMock('JMS\Serializer\VisitorInterface');
        $visitor->expects($this->once())
            ->method('visitInteger')
            ->with(1, array('foo'), $context)
            ->willReturn(true);

        $serializer = new FooSerializer($manager);

        $this->assertTrue($serializer->serializeObjectToId($visitor, $modelInstance, array('foo'), $context));
    }

    public function testSerializeObjectToIdWithDataIsNotInstanceOfManager()
    {
        $modelInstance = $this->getMockBuilder('Sonata\CoreBundle\Tests\Fixtures\Bundle\Serializer\FooSerializer')
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');
        $manager->expects($this->once())
            ->method('getClass')
            ->willReturn('bar');

        $context = $this->createMock('JMS\Serializer\Context');

        $visitor = $this->createMock('JMS\Serializer\VisitorInterface');
        $visitor->expects($this->never())
            ->method('visitInteger');

        $serializer = new FooSerializer($manager);

        $serializer->serializeObjectToId($visitor, $modelInstance, array('foo'), $context);
    }

    public function testDeserializeObjectFromId()
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');
        $manager->expects($this->once())
            ->method('findOneBy')
            ->with(array('id' => 'foo'))
            ->willReturn('bar');

        $visitor = $this->createMock('JMS\Serializer\VisitorInterface');

        $serializer = new FooSerializer($manager);

        $this->assertSame('bar', $serializer->deserializeObjectFromId($visitor, 'foo', array()));
    }
}
