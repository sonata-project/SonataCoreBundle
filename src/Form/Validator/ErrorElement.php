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

namespace Sonata\Form\Validator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class ErrorElement
{
    /**
     * @var ExecutionContextInterface
     */
    private $context;

    /**
     * @var string
     */
    private $group;

    /**
     * @var ConstraintValidatorFactoryInterface
     */
    private $constraintValidatorFactory;

    /**
     * @var string[]
     */
    private $stack = [];

    /**
     * @var string[]
     */
    private $propertyPaths = [];

    /**
     * @var mixed
     */
    private $subject;

    /**
     * @var string
     */
    private $current = '';

    /**
     * @var string
     */
    private $basePropertyPath;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param mixed  $subject
     * @param string $group
     */
    public function __construct(
        $subject,
        ConstraintValidatorFactoryInterface $constraintValidatorFactory,
        ExecutionContextInterface $context,
        ?string $group
    ) {
        $this->subject = $subject;
        $this->context = $context;
        $this->group = $group;
        $this->constraintValidatorFactory = $constraintValidatorFactory;
        $this->basePropertyPath = $this->context->getPropertyPath();
    }

    /**
     * @throws \RuntimeException
     */
    public function __call(string $name, array $arguments = []): self
    {
        if ('assert' === substr($name, 0, 6)) {
            $this->validate($this->newConstraint(substr($name, 6), $arguments[0] ?? []));
        } else {
            throw new \RuntimeException('Unable to recognize the command');
        }

        return $this;
    }

    public function addConstraint(Constraint $constraint): self
    {
        $this->validate($constraint);

        return $this;
    }

    public function with(string $name, bool $key = false): self
    {
        $key = $key ? $name.'.'.$key : $name;
        $this->stack[] = $key;

        $this->current = implode('.', $this->stack);

        if (!isset($this->propertyPaths[$this->current])) {
            $this->propertyPaths[$this->current] = new PropertyPath($this->current);
        }

        return $this;
    }

    public function end(): self
    {
        array_pop($this->stack);

        $this->current = implode('.', $this->stack);

        return $this;
    }

    public function getFullPropertyPath(): string
    {
        if ($this->getCurrentPropertyPath()) {
            return sprintf('%s.%s', $this->basePropertyPath, $this->getCurrentPropertyPath());
        }

        return $this->basePropertyPath;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string|array $message
     */
    public function addViolation($message, array $parameters = [], $value = null): self
    {
        if (\is_array($message)) {
            $value = $message[2] ?? $value;
            $parameters = isset($message[1]) ? (array) $message[1] : [];
            $message = $message[0] ?? 'error';
        }

        $this->context->buildViolation($message)
           ->atPath((string) $this->getCurrentPropertyPath())
           ->setParameters($parameters)
           ->setInvalidValue($value)
           ->addViolation();

        $this->errors[] = [$message, $parameters, $value];

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validate(Constraint $constraint): void
    {
        $this->context->getValidator()
            ->inContext($this->context)
            ->atPath((string) $this->getCurrentPropertyPath())
            ->validate($this->getValue(), $constraint, [$this->group]);
    }

    /**
     * Return the value linked to.
     *
     * @return mixed
     */
    private function getValue()
    {
        if ('' === $this->current) {
            return $this->subject;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        return $propertyAccessor->getValue($this->subject, $this->getCurrentPropertyPath());
    }

    /**
     * @return object
     */
    private function newConstraint(string $name, array $options = [])
    {
        if (false !== strpos($name, '\\') && class_exists($name)) {
            $className = (string) $name;
        } else {
            $className = 'Symfony\\Component\\Validator\\Constraints\\'.$name;
        }

        return new $className($options);
    }

    private function getCurrentPropertyPath(): ?PropertyPath
    {
        if (!isset($this->propertyPaths[$this->current])) {
            return null; //global error
        }

        return $this->propertyPaths[$this->current];
    }
}
