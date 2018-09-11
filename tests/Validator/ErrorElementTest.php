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

namespace Sonata\CoreBundle\Tests\Validator;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Tests\Fixtures\Bundle\Entity\Foo;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ContextualValidatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * @author Andrej Hudec <pulzarraider@gmail.com>
 */
class ErrorElementTest extends TestCase
{
    private $errorElement;
    private $context;
    private $contextualValidator;
    private $subject;

    protected function setUp(): void
    {
        $constraintValidatorFactory = $this->createMock(ConstraintValidatorFactoryInterface::class);

        $this->context = $this->createMock(ExecutionContextInterface::class);
        $this->context->expects($this->once())
                ->method('getPropertyPath')
                ->will($this->returnValue('bar'));

        $builder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $builder->expects($this->any())
            ->method($this->anything())
            ->will($this->returnSelf());

        $this->context->expects($this->any())
            ->method('buildViolation')
            ->willReturn($builder);

        $validator = $this->createMock(ValidatorInterface::class);

        $this->contextualValidator = $this->createMock(ContextualValidatorInterface::class);
        $this->contextualValidator->expects($this->any())
            ->method($this->anything())
            ->will($this->returnSelf());
        $validator->expects($this->any())
            ->method('inContext')
            ->willReturn($this->contextualValidator);

        $this->context->expects($this->any())
            ->method('getValidator')
            ->willReturn($validator);

        $this->subject = new Foo();

        $this->errorElement = new ErrorElement($this->subject, $constraintValidatorFactory, $this->context, 'foo_core');
    }

    public function testGetSubject(): void
    {
        $this->assertSame($this->subject, $this->errorElement->getSubject());
    }

    public function testGetErrorsEmpty(): void
    {
        $this->assertSame([], $this->errorElement->getErrors());
    }

    public function testGetErrors(): void
    {
        $this->errorElement->addViolation('Foo error message', ['bar_param' => 'bar_param_lvalue'], 'BAR');
        $this->assertSame([['Foo error message', ['bar_param' => 'bar_param_lvalue'], 'BAR']], $this->errorElement->getErrors());
    }

    public function testAddViolation(): void
    {
        $this->errorElement->addViolation(['Foo error message', ['bar_param' => 'bar_param_lvalue'], 'BAR']);
        $this->assertSame([['Foo error message', ['bar_param' => 'bar_param_lvalue'], 'BAR']], $this->errorElement->getErrors());
    }

    public function testAddConstraint(): void
    {
        $constraint = new NotNull();

        $this->contextualValidator->expects($this->once())
            ->method('atPath')
            ->with('');
        $this->contextualValidator->expects($this->once())
            ->method('validate')
            ->with($this->subject, $constraint, ['foo_core']);

        $this->errorElement->addConstraint($constraint);
    }

    public function testWith(): void
    {
        $constraint = new NotNull();

        $this->contextualValidator->expects($this->once())
            ->method('atPath')
            ->with('bar');
        $this->contextualValidator->expects($this->once())
            ->method('validate')
            ->with(null, $constraint, ['foo_core']);

        $this->errorElement->with('bar');
        $this->errorElement->addConstraint($constraint);
        $this->errorElement->end();
    }

    public function testCall(): void
    {
        $constraint = new NotNull();

        $this->contextualValidator->expects($this->once())
            ->method('atPath')
            ->with('bar');
        $this->contextualValidator->expects($this->once())
            ->method('validate')
            ->with(null, $constraint, ['foo_core']);

        $this->errorElement->with('bar');
        $this->errorElement->assertNotNull();
        $this->errorElement->end();
    }

    public function testCallException(): void
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Unable to recognize the command');

        $this->errorElement->with('bar');
        $this->errorElement->baz();
    }

    public function testGetFullPropertyPath(): void
    {
        $this->errorElement->with('baz');
        $this->assertSame('bar.baz', $this->errorElement->getFullPropertyPath());
        $this->errorElement->end();

        $this->assertSame('bar', $this->errorElement->getFullPropertyPath());
    }

    public function testFluidInterface(): void
    {
        $constraint = new NotNull();

        $this->contextualValidator->expects($this->any())
            ->method('atPath')
            ->with('');
        $this->contextualValidator->expects($this->any())
            ->method('validate')
            ->with($this->subject, $constraint, ['foo_core']);

        $this->assertSame($this->errorElement, $this->errorElement->with('baz'));
        $this->assertSame($this->errorElement, $this->errorElement->end());
        $this->assertSame($this->errorElement, $this->errorElement->addViolation('Foo error message', ['bar_param' => 'bar_param_lvalue'], 'BAR'));
        $this->assertSame($this->errorElement, $this->errorElement->addConstraint($constraint));
        $this->assertSame($this->errorElement, $this->errorElement->assertNotNull());
    }
}
