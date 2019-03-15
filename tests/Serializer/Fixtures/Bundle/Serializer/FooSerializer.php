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

namespace Sonata\Serializer\Tests\Fixtures\Bundle\Serializer;

use Sonata\Doctrine\Model\ManagerInterface;
use Sonata\Serializer\BaseSerializerHandler;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
class FooSerializer extends BaseSerializerHandler
{
    /**
     * @param ManagerInterface $manager
     */
    public function __construct(ManagerInterface $manager)
    {
        parent::__construct($manager);
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'foo';
    }
}
