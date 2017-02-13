<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

/**
 * NEXT_MAJOR: Remove this class when dropping support for < PHPUnit 5.4.
 *
 * @internal
 */
class TypeTestCase extends \Symfony\Component\Form\Test\TypeTestCase
{
    /**
     * @param string $class
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMock($class)
    {
        if (is_callable('parent::createMock')) {
            return parent::createMock($class);
        }

        return $this->getMock($class);
    }
}
