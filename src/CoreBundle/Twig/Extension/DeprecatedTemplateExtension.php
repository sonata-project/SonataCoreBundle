<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\Extension;

use Sonata\CoreBundle\Twig\TokenParser\DeprecatedTemplateTokenParser;
use Twig\Extension\AbstractExtension;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class DeprecatedTemplateExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new DeprecatedTemplateTokenParser(),
        ];
    }
}
