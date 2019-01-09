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

namespace Sonata\Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class DeprecatedTemplateNode extends Node
{
    public function __construct(AbstractExpression $newTemplate, $line, $tag = null)
    {
        parent::__construct(['newTemplate' => $newTemplate], [], $line, $tag);
    }

    public function compile(Compiler $compiler)
    {
        @trigger_error(sprintf(
            'The "%s" template is deprecated. Use "%s" instead.',
            $this->getTemplateName(),
            $this->getNode('newTemplate')->getAttribute('value')
        ), E_USER_DEPRECATED);
    }
}

class_exists(\Sonata\CoreBundle\Twig\Node\DeprecatedTemplateNode::class);
