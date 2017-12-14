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
use Sonata\CoreBundle\Tests\Fixtures\Bundle\Validator\FooValidatorService;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\CoreBundle\Validator\InlineValidator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
final class InlineValidatorTest extends TestCase
{
    private $container;
    private $constraintValidatorFactory;
    private $context;

    public function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->constraintValidatorFactory = $this->createMock(ConstraintValidatorFactoryInterface::class);
        $this->context = $this->createMock(ExecutionContextInterface::class);
    }

    public function testGetErrorElement(): void
    {
        $inlineValidator = new InlineValidator($this->container, $this->constraintValidatorFactory);

        $inlineValidator->initialize($this->context);

        $reflectorObject = new \ReflectionObject($inlineValidator);
        $reflectedMethod = $reflectorObject->getMethod('getErrorElement');
        $reflectedMethod->setAccessible(true);

        $errorElement = $reflectedMethod->invokeArgs($inlineValidator, ['foo']);

        $this->assertInstanceOf(ErrorElement::class, $errorElement);
        $this->assertSame('foo', $errorElement->getSubject());
    }

    public function testValidateWithConstraintIsClosure(): void
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('foo is equal to foo');

        $constraint = $this->getMockBuilder(Constraint::class)
            ->setMethods(['isClosure', 'getClosure'])
            ->getMock();

        $constraint->expects($this->once())
            ->method('isClosure')
            ->willReturn(true);

        $constraint->expects($this->once())
            ->method('getClosure')
            ->willReturn(function (ErrorElement $errorElement, $value): void {
                throw new ValidatorException($errorElement->getSubject().' is equal to '.$value);
            });

        $inlineValidator = new InlineValidator($this->container, $this->constraintValidatorFactory);

        $inlineValidator->initialize($this->context);

        $inlineValidator->validate('foo', $constraint);
    }

    public function testValidateWithConstraintGetServiceIsString(): void
    {
        $constraint = $this->getMockBuilder(Constraint::class)
            ->setMethods([
                'isClosure',
                'getService',
                'getMethod',
            ])
            ->getMock();

        $constraint->expects($this->once())
            ->method('isClosure')
            ->willReturn(false);

        $constraint->expects($this->any())
            ->method('getService')
            ->willReturn('string');

        $constraint->expects($this->once())
            ->method('getMethod')
            ->willReturn('fooValidatorMethod');

        $this->container->expects($this->once())
            ->method('get')
            ->with('string')
            ->willReturn(new FooValidatorService());

        $inlineValidator = new InlineValidator($this->container, $this->constraintValidatorFactory);

        $inlineValidator->initialize($this->context);

        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('foo is equal to foo');

        $inlineValidator->validate('foo', $constraint);
    }

    public function testValidateWithConstraintGetServiceIsNotString(): void
    {
        $constraint = $this->getMockBuilder(Constraint::class)
            ->setMethods([
                'isClosure',
                'getService',
                'getMethod',
            ])
            ->getMock();

        $constraint->expects($this->once())
            ->method('isClosure')
            ->willReturn(false);

        $constraint->expects($this->any())
            ->method('getService')
            ->willReturn(new FooValidatorService());

        $constraint->expects($this->once())
            ->method('getMethod')
            ->willReturn('fooValidatorMethod');

        $inlineValidator = new InlineValidator($this->container, $this->constraintValidatorFactory);

        $inlineValidator->initialize($this->context);

        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('foo is equal to foo');

        $inlineValidator->validate('foo', $constraint);
    }
}
