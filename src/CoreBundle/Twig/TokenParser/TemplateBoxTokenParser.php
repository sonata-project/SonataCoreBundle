<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\TokenParser;

use Sonata\CoreBundle\Twig\Node\TemplateBoxNode;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Node\Expression\ConstantExpression;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

class TemplateBoxTokenParser extends AbstractTokenParser
{
    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param bool $enabled Is Symfony debug enabled?
     */
    public function __construct($enabled, TranslatorInterface $translator)
    {
        $this->enabled = $enabled;
        $this->translator = $translator;
    }

    public function parse(Token $token)
    {
        if ($this->parser->getStream()->test(Token::STRING_TYPE)) {
            $message = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $message = new ConstantExpression('Template information', $token->getLine());
        }

        if ($this->parser->getStream()->test(Token::STRING_TYPE)) {
            $translationBundle = $this->parser->getExpressionParser()->parseExpression();
        } else {
            $translationBundle = null;
        }

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new TemplateBoxNode($message, $translationBundle, $this->enabled, $this->translator, $token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return 'sonata_template_box';
    }
}
