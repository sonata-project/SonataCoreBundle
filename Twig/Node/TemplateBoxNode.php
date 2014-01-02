<?php

/*
 * This file is part of sonata-project.
 *
 * (c) 2010 Thomas Rabaix
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\Node;

class TemplateBoxNode extends \Twig_Node
{
    protected $enabled;

    /**
     * @param \Twig_Node_Expression $message
     * @param int                   $enabled
     * @param null|string           $lineno
     * @param null                  $tag
     */
    public function __construct(\Twig_Node_Expression $message, $enabled, $lineno, $tag = null)
    {
        $this->enabled = $enabled;

        parent::__construct(array('message' => $message), array(), $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this);

        if (!$this->enabled) {
            $compiler->write("// token for sonata_template_box, however the box is disabled");
            return;
        }

        $message = <<<CODE
"<div class='alert alert-default alert-info'>
    <strong>{$this->getNode('message')->getAttribute('value')}</strong>
    <div>This file can be found in <code>{\$this->getTemplateName()}</code>.</div>
</div>"
CODE;

        $compiler
            ->write("echo $message;");
        ;
    }
}
