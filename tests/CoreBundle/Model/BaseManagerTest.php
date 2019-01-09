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

namespace Sonata\CoreBundle\Tests\Model;

use Doctrine\Common\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Tests\Fixtures\Model\Manager;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class BaseManagerTest extends TestCase
{
    /**
     * @group legacy
     */
    public function testCheckObject()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Object must be instance of class, DateTime given');

        $manager = new Manager('class', $this->createMock(ManagerRegistry::class));

        $manager->publicCheckObject(new \DateTime());
    }
}
