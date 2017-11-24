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

class TemplateBoxNode extends \Twig_Node
{
    /**
     * @var int
     */
    protected $enabled;

    /**
     * @param \Twig_Node_Expression $message Node message to display
     * @param int                   $enabled Is Symfony debug enabled?
     * @param null|string           $lineno  Symfony template line number
     * @param null                  $tag     Symfony tag name
     */
    public function __construct(\Twig_Node_Expression $message, $enabled, $lineno, $tag = null)
    {
        $this->enabled = $enabled;

        parent::__construct(['message' => $message], [], $lineno, $tag);
    }

    /**
     * {@inheritdoc}
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this);

        if (!$this->enabled) {
            $compiler->write("// token for sonata_template_box, however the box is disabled\n");

            return;
        }

        $value = $this->getNode('message')->getAttribute('value');

        $message = <<<CODE
"<div class='alert alert-default alert-info'>
    <strong>{$value}</strong>
    <div>This file can be found in <code>{\$this->getTemplateName()}</code>.</div>
</div>"
CODE;

        $compiler
            ->write("echo $message;");
    }
}
