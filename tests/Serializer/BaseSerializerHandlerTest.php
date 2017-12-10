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

namespace Sonata\CoreBundle\Tests\Serializer;

use JMS\Serializer\GraphNavigator;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Tests\Fixtures\Bundle\Serializer\FooSerializer;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class BaseSerializerHandlerTest extends TestCase
{
    public function testSetFormats(): void
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');

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

    public function testAddFormats(): void
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');

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

    public function testSerializeObjectToIdWithDataIsInstanceOfManager(): void
    {
        $modelInstance = $this->getMockBuilder('Sonata\CoreBundle\Tests\Fixtures\Bundle\Serializer\FooSerializer')
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
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
            ->with(1, ['foo'], $context)
            ->willReturn(true);

        $serializer = new FooSerializer($manager);

        $this->assertTrue($serializer->serializeObjectToId($visitor, $modelInstance, ['foo'], $context));
    }

    public function testSerializeObjectToIdWithDataIsNotInstanceOfManager(): void
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

        $serializer->serializeObjectToId($visitor, $modelInstance, ['foo'], $context);
    }

    public function testDeserializeObjectFromId(): void
    {
        $manager = $this->createMock('Sonata\CoreBundle\Model\ManagerInterface');
        $manager->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 'foo'])
            ->willReturn('bar');

        $visitor = $this->createMock('JMS\Serializer\VisitorInterface');

        $serializer = new FooSerializer($manager);

        $this->assertSame('bar', $serializer->deserializeObjectFromId($visitor, 'foo', []));
    }
}
