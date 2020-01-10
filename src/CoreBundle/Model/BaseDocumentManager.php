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

namespace Sonata\CoreBundle\Model;

if (!class_exists(\Sonata\Doctrine\Document\BaseDocumentManager::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\BaseDocumentManager class is deprecated since version 3.12.0 and will be removed in 4.0.'
        .' Use Sonata\Doctrine\Document\BaseDocumentManager instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Doctrine\Document\BaseDocumentManager::class,
    __NAMESPACE__.'\BaseDocumentManager'
);

if (false) {
    /**
     * @author Hugo Briand <briand@ekino.com>
     *
     * @deprecated since sonata-project/core-bundle 3.12.0, to be removed in 4.0.
     */
    abstract class BaseDocumentManager extends \Sonata\Doctrine\Document\BaseDocumentManager implements ManagerInterface
    {
    }
}
