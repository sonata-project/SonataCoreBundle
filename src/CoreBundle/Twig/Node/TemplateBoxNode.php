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

namespace Sonata\CoreBundle\Twig\Node;

if (!class_exists(\Sonata\Twig\Node\TemplateBoxNode::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\TemplateBoxNode class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\Node\TemplateBoxNode instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Twig\Node\TemplateBoxNode::class,
    __NAMESPACE__.'\TemplateBoxNode'
);

if (false) {
    /**
     * @deprecated Since version 3.13.0, to be removed in 4.0.
     */
    class TemplateBoxNode extends \Sonata\Twig\Node\TemplateBoxNode
    {
    }
}
