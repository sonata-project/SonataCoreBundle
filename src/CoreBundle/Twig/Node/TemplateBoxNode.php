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

use Symfony\Component\Translation\TranslatorInterface;
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;
use Twig\Node\Node;

class TemplateBoxNode extends Node
{
    /**
     * @var int
     */
    protected $enabled;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param AbstractExpression $message           Node message to display
     * @param AbstractExpression $translationBundle Node translation bundle to use for display
     * @param int                $enabled           Is Symfony debug enabled?
     * @param null|string        $lineno            Symfony template line number
     * @param null               $tag               Symfony tag name
     */
    public function __construct(
        AbstractExpression $message,
        AbstractExpression $translationBundle = null,
        $enabled,
        TranslatorInterface $translator,
        $lineno,
        $tag = null
    ) {
        $this->enabled = $enabled;
        $this->translator = $translator;

        $nodes = ['message' => $message];

        if ($translationBundle) {
            $nodes['translationBundle'] = $translationBundle;
        }

        parent::__construct($nodes, [], $lineno, $tag);
    }

    public function compile(Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this);

        if (!$this->enabled) {
            $compiler->write("// token for sonata_template_box, however the box is disabled\n");

            return;
        }

        $value = $this->getNode('message')->getAttribute('value');

        $translationBundle = null;

        if ($this->hasNode('translationBundle')) {
            $translationBundle = $this->getNode('translationBundle');
        }

        if ($translationBundle) {
            $translationBundle = $translationBundle->getAttribute('value');
        }

        $message = <<<CODE
"<div class='alert alert-default alert-info'>
    <strong>{$this->translator->trans($value, [], $translationBundle)}</strong>
    <div>{$this->translator->trans('sonata_core_template_box_file_found_in', [], 'SonataCoreBundle')} <code>{\$this->getTemplateName()}</code>.</div>
</div>"
CODE;

        $compiler
            ->write("echo $message;");
    }
}
