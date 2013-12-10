<?php

/*
 * This file is part of sonata-project.
 *
 * (c) 2010 Thomas Rabaix
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\TokenParser;

use Sonata\CoreBundle\Twig\Node\TemplateBoxNode;

class TemplateBoxTokenParser extends \Twig_TokenParser
{

    protected $enabled;

    /**
     * @param bool $enabled
     */
    public function __construct($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(\Twig_Token $token)
    {
        if ($this->parser->getStream()->test(\Twig_Token::STRING_TYPE)) {
            $message = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $message = new \Twig_Node_Expression_Constant('Template information', $token->getLine());
        }

        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        return new TemplateBoxNode($message, $this->enabled, $token->getLine(), $this->getTag());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'sonata_template_box';
    }
}
