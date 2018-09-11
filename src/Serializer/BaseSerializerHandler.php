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

namespace Sonata\CoreBundle\Serializer;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\VisitorInterface;
use Sonata\CoreBundle\Model\ManagerInterface;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
abstract class BaseSerializerHandler implements SerializerHandlerInterface
{
    /**
     * @var ManagerInterface
     */
    protected $manager;

    /**
     * @var string[]
     */
    protected static $formats;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param string[] $formats
     */
    final public static function setFormats(array $formats): void
    {
        static::$formats = $formats;
    }

    final public static function addFormat(string $format): void
    {
        static::$formats[] = $format;
    }

    public static function getSubscribingMethods(): array
    {
        $type = static::getType();
        $methods = [];

        foreach (static::$formats as $format) {
            $methods[] = [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => $format,
                'type' => $type,
                'method' => 'serializeObjectToId',
            ];

            $methods[] = [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'type' => $type,
                'method' => 'deserializeObjectFromId',
            ];
        }

        return $methods;
    }

    /**
     * Serialize data object to id.
     *
     * @param object $data
     */
    public function serializeObjectToId(
        VisitorInterface $visitor,
        $data,
        array $type,
        Context $context
    ): ?int {
        $className = $this->manager->getClass();

        if ($data instanceof $className) {
            return $visitor->visitInteger($data->getId(), $type, $context);
        }

        return null;
    }

    /**
     * Deserialize object from its id.
     *
     * @return null|object
     */
    public function deserializeObjectFromId(VisitorInterface $visitor, int $data, array $type)
    {
        return $this->manager->findOneBy(['id' => $data]);
    }
}
