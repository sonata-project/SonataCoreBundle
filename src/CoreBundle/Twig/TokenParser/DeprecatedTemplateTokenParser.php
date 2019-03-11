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

namespace Sonata\CoreBundle\Twig\TokenParser;

if (!class_exists(\Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\DeprecatedTemplateTokenParser class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser::class,
    __NAMESPACE__.'\DeprecatedTemplateTokenParser'
);

if (false) {
    /**
     * @author Marko Kunic <kunicmarko20@gmail.com>
     *
     * @deprecated Since version 3.13.0, to be removed in 4.0.
     */
    final class DeprecatedTemplateTokenParser extends \Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser
    {
    }
}
