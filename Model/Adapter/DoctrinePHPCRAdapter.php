<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Model\Adapter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\PHPCR\DocumentManager;

/**
 * This is a port of the DoctrineORMAdminBundle / ModelManager class
 *
 * @package Sonata\CoreBundle\Model\Adapter
 */
class DoctrinePHPCRAdapter implements AdapterInterface
{
    protected $registry;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function getNormalizedIdentifier($document)
    {
        if (is_scalar($document)) {
            throw new \RunTimeException('Invalid argument, object or null required');
        }

        if (!$document) {
            return null;
        }

        $manager = $this->registry->getManagerForClass(ClassUtils::getClass($document));

        if (!$manager instanceof DocumentManager) {
            return null;
        }

        if (!$manager->contains($document)) {
            return null;
        }

        $class = $manager->getClassMetadata(get_class($document));

        return $class->getIdentifierValue($document);
    }

    /**
     * Currently only the leading slash is removed.
     *
     * TODO: do we also have to encode certain characters like spaces or does that happen automatically?
     *
     * {@inheritDoc}
     */
    public function getUrlsafeIdentifier($document)
    {
        $id = $this->getNormalizedIdentifier($document);

        if (null !== $id) {
            return substr($id, 1);
        }

        return null;
    }
}
