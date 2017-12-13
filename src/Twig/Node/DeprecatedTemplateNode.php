<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
final class DeprecatedTemplateNode extends Node
{
    public function __construct(AbstractExpression $newTemplate, $line, $tag = null)
    {
        parent::__construct(['newTemplate' => $newTemplate], [], $line, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(Compiler $compiler)
    {
        @trigger_error(sprintf(
            'The "%s" template is deprecated. Use "%s" instead.',
            $this->getTemplateName(),
            $this->getNode('newTemplate')->getAttribute('value')
        ), E_USER_DEPRECATED);
    }
}
