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

namespace Sonata\Form\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Sonata\Form\EventListener\ResizeFormListener;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
class ResizeFormListenerTest extends TestCase
{
    public function testGetSubscribedEvents()
    {
        $events = ResizeFormListener::getSubscribedEvents();

        $this->assertArrayHasKey(FormEvents::PRE_SET_DATA, $events);
        $this->assertSame('preSetData', $events[FormEvents::PRE_SET_DATA]);
        $this->assertArrayHasKey(FormEvents::PRE_SUBMIT, $events);
        $this->assertSame('preBind', $events[FormEvents::PRE_SUBMIT]);
        $this->assertArrayHasKey(FormEvents::SUBMIT, $events);
        $this->assertSame('onBind', $events[FormEvents::SUBMIT]);
    }

    public function testPreSetDataWithNullData()
    {
        $listener = new ResizeFormListener('form', [], false, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator());
        $form->expects($this->never())
            ->method('add');

        $event = new FormEvent($form, null);

        $listener->preSetData($event);
    }

    public function testPreSetDataThrowsExceptionWithStringEventData()
    {
        $listener = new ResizeFormListener('form', [], false, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();

        $event = new FormEvent($form, '');

        $this->expectException(UnexpectedTypeException::class);

        $listener->preSetData($event);
    }

    public function testPreSetData()
    {
        $typeOptions = [
            'default' => 'option',
        ];

        $listener = new ResizeFormListener('form', $typeOptions, false, null);

        $options = [
            'property_path' => '[baz]',
            'data' => 'caz',
            'default' => 'option',
        ];

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['foo' => 'bar']));
        $form->expects($this->once())
            ->method('remove')
            ->with('foo');
        $form->expects($this->once())
            ->method('add')
            ->with('baz', 'form', $options);

        $data = ['baz' => 'caz'];

        $event = new FormEvent($form, $data);

        $listener->preSetData($event);
    }

    public function testPreSubmitWithResizeOnBindFalse()
    {
        $listener = new ResizeFormListener('form', [], false, null);

        $event = $this->getMockBuilder(FormEvent::class)->disableOriginalConstructor()->getMock();
        $event->expects($this->never())
            ->method('getForm');

        $listener->preSubmit($event);
    }

    public function testPreSubmitDataWithNullData()
    {
        $listener = new ResizeFormListener('form', [], true, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['foo' => 'bar']));
        $form->expects($this->never())
            ->method('has');

        $event = new FormEvent($form, null);

        $listener->preSubmit($event);
    }

    public function testPreSubmitThrowsExceptionWithIntEventData()
    {
        $listener = new ResizeFormListener('form', [], true, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();

        $event = new FormEvent($form, 123);

        $this->expectException(UnexpectedTypeException::class);

        $listener->preSubmit($event);
    }

    public function testPreSubmitData()
    {
        $typeOptions = [
            'default' => 'option',
        ];

        $listener = new ResizeFormListener('form', $typeOptions, true, null);

        $options = [
            'property_path' => '[baz]',
            'default' => 'option',
        ];

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['foo' => 'bar']));
        $form->expects($this->once())
            ->method('remove')
            ->with('foo');
        $form->expects($this->once())
            ->method('add')
            ->with('baz', 'form', $options);

        $data = ['baz' => 'caz'];

        $event = new FormEvent($form, $data);

        $listener->preSubmit($event);
    }

    public function testPreSubmitDataWithClosure()
    {
        $typeOptions = [
            'default' => 'option',
        ];

        $data = ['baz' => 'caz'];

        $closure = static function () use ($data) {
            return $data['baz'];
        };

        $listener = new ResizeFormListener('form', $typeOptions, true, $closure);

        $options = [
            'property_path' => '[baz]',
            'default' => 'option',
            'data' => 'caz',
        ];

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator(['foo' => 'bar']));
        $form->expects($this->once())
            ->method('remove')
            ->with('foo');
        $form->expects($this->once())
            ->method('add')
            ->with('baz', 'form', $options);

        $event = new FormEvent($form, $data);

        $listener->preSubmit($event);
    }

    public function testOnSubmitWithResizeOnBindFalse()
    {
        $listener = new ResizeFormListener('form', [], false, null);

        $event = $this->getMockBuilder(FormEvent::class)->disableOriginalConstructor()->getMock();
        $event->expects($this->never())
            ->method('getForm');

        $listener->onSubmit($event);
    }

    public function testOnSubmitDataWithNullData()
    {
        $listener = new ResizeFormListener('form', [], true, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->never())
            ->method('has');

        $event = new FormEvent($form, null);

        $listener->onSubmit($event);
    }

    public function testOnSubmitThrowsExceptionWithIntEventData()
    {
        $listener = new ResizeFormListener('form', [], true, null);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();

        $event = new FormEvent($form, 123);

        $this->expectException(UnexpectedTypeException::class);

        $listener->onSubmit($event);
    }

    public function testOnSubmit()
    {
        $listener = new ResizeFormListener('form', [], true, null);

        $reflector = new \ReflectionClass(ResizeFormListener::class);
        $reflectedMethod = $reflector->getProperty('removed');
        $reflectedMethod->setAccessible(true);
        $reflectedMethod->setValue($listener, ['foo']);

        $form = $this->getMockBuilder(Form::class)->disableOriginalConstructor()->getMock();
        $form->expects($this->at(2))
            ->method('has')
            ->with('baz')
            ->willReturn(true);

        $data = [
            'foo' => 'foo-value',
            'bar' => 'bar-value',
            'baz' => 'baz-value',
        ];

        $removedData = [
            'baz' => 'baz-value',
        ];

        $event = $this->getMockBuilder(FormEvent::class)->disableOriginalConstructor()->getMock();
        $event->expects($this->once())
            ->method('getForm')
            ->willReturn($form);
        $event->expects($this->once())
            ->method('getData')
            ->willReturn($data);
        $event->expects($this->once())
            ->method('setData')
            ->with($removedData);

        $listener->onSubmit($event);
    }
}
