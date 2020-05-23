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

namespace Sonata\Twig\Tests\Fixtures\Bundle\Serializer;

use Sonata\Doctrine\Model\ManagerInterface;
use Sonata\Form\Serializer\BaseSerializerHandler;

/**
 * @author Ahmet Akbana <ahmetakbana@gmail.com>
 */
class FooSerializer extends BaseSerializerHandler
{
    public function __construct(ManagerInterface $manager)
    {
        parent::__construct($manager);
    }

    /**
     * {@inheritdoc}
     */
    public static function getType(): string
    {
        return 'foo';
    }
}
