<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;

class InlineValidator extends ConstraintValidator
{
    protected $container;

    protected $constraintValidatorFactory;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface            $container
     * @param \Symfony\Bundle\FrameworkBundle\Validator\ConstraintValidatorFactory $constraintValidatorFactory
     */
    public function __construct(ContainerInterface $container, ConstraintValidatorFactoryInterface $constraintValidatorFactory)
    {
        $this->container                  = $container;
        $this->constraintValidatorFactory = $constraintValidatorFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        $errorElement = $this->getErrorElement($value);

        if ($constraint->isClosure()) {
            $function = $constraint->getClosure();
        } else {
            if (is_string($constraint->getService())) {
                $service = $this->container->get($constraint->getService());
            } else {
                $service = $constraint->getService();
            }

            $function = array($service, $constraint->getMethod());
        }

        call_user_func($function, $errorElement, $value);
    }

    /**
     * @param mixed $value
     *
     * @return ErrorElement
     */
    protected function getErrorElement($value)
    {
        return new ErrorElement(
            $value,
            $this->constraintValidatorFactory,
            $this->context,
            $this->context->getGroup()
        );
    }
}
