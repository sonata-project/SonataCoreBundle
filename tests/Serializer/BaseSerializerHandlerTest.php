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

namespace Sonata\Serializer\Tests;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\VisitorInterface;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\Serializer\BaseSerializerHandler;
use Sonata\Serializer\Tests\Fixtures\Bundle\Serializer\FooSerializer;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class BaseSerializerHandlerTest extends TestCase
{
    public function setUp()
    {
        BaseSerializerHandler::setFormats(['json', 'xml', 'yml']);
    }

    /**
     * @group legacy
     *
     * NEXT_MAJOR : this should call setFormats method
     */
    public function testGetSubscribingMethodsWithDefaultFormats()
    {
        $manager = $this->createMock(ManagerInterface::class);

        $serializer = new FooSerializer($manager);

        $expectedMethods = [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'xml',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'xml',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'yml',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'yml',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
        ];

        $methods = $serializer::getSubscribingMethods();

        $this->assertSame($methods, $expectedMethods);
    }

    public function testSetFormats()
    {
        $manager = $this->createMock(ManagerInterface::class);

        $serializer = new FooSerializer($manager);

        $expectedMethods = [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
        ];

        $serializer::setFormats(['bar']);

        $methods = $serializer::getSubscribingMethods();

        $this->assertSame($methods, $expectedMethods);
    }

    public function testAddFormats()
    {
        $manager = $this->createMock(ManagerInterface::class);

        $serializer = new FooSerializer($manager);

        $expectedMethods = [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'bar',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'foo',
                'type' => 'foo',
                'method' => 'serializeObjectToId',
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'foo',
                'type' => 'foo',
                'method' => 'deserializeObjectFromId',
            ],
        ];

        $serializer::setFormats(['bar']);

        $serializer::addFormat('foo');

        $methods = $serializer::getSubscribingMethods();

        $this->assertSame($methods, $expectedMethods);
    }

    public function testSerializeObjectToIdWithDataIsInstanceOfManager()
    {
        $modelInstance = $this->getMockBuilder(FooSerializer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();

        $modelInstance->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $manager = $this->createMock(ManagerInterface::class);
        $manager->expects($this->once())
            ->method('getClass')
            ->willReturn(\get_class($modelInstance));

        $context = $this->createMock(Context::class);

        $visitor = $this->createMock(VisitorInterface::class);
        $visitor->expects($this->once())
            ->method('visitInteger')
            ->with(1, ['foo'], $context)
            ->willReturn(true);

        $serializer = new FooSerializer($manager);

        $this->assertTrue($serializer->serializeObjectToId($visitor, $modelInstance, ['foo'], $context));
    }

    public function testSerializeObjectToIdWithDataIsNotInstanceOfManager()
    {
        $modelInstance = $this->getMockBuilder(FooSerializer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $manager = $this->createMock(ManagerInterface::class);
        $manager->expects($this->once())
            ->method('getClass')
            ->willReturn('bar');

        $context = $this->createMock(Context::class);

        $visitor = $this->createMock(VisitorInterface::class);
        $visitor->expects($this->never())
            ->method('visitInteger');

        $serializer = new FooSerializer($manager);

        $serializer->serializeObjectToId($visitor, $modelInstance, ['foo'], $context);
    }

    public function testDeserializeObjectFromId()
    {
        $manager = $this->createMock(ManagerInterface::class);
        $manager->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 'foo'])
            ->willReturn('bar');

        $visitor = $this->createMock(VisitorInterface::class);

        $serializer = new FooSerializer($manager);

        $this->assertSame('bar', $serializer->deserializeObjectFromId($visitor, 'foo', []));
    }
}
