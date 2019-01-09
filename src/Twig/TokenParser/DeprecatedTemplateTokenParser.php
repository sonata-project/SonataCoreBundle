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

namespace Sonata\Twig\TokenParser;

use Sonata\Twig\Node\DeprecatedTemplateNode;
use Twig\Token;
use Twig\TokenParser\AbstractTokenParser;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class DeprecatedTemplateTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        if (!$this->parser->getStream()->test(Token::STRING_TYPE)) {
            throw new \InvalidArgumentException('New template name is mandatory.');
        }

        $newTemplate = $this->parser->getExpressionParser()->parseExpression();

        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);

        return new DeprecatedTemplateNode($newTemplate, $token->getLine(), $this->getTag());
    }

    public function getTag()
    {
        return 'sonata_template_deprecate';
    }
}

class_exists(\Sonata\CoreBundle\Twig\TokenParser\DeprecatedTemplateTokenParser::class);
