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

namespace Sonata\Twig\Extension;

use Sonata\Twig\TokenParser\DeprecatedTemplateTokenParser;
use Twig\Extension\AbstractExtension;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class DeprecatedTemplateExtension extends AbstractExtension
{
    public function getTokenParsers()
    {
        return [
            new DeprecatedTemplateTokenParser(),
        ];
    }
}

class_exists(\Sonata\CoreBundle\Twig\Extension\DeprecatedTemplateExtension::class);
