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

namespace Sonata\Twig\Tests\TokenParser;

use PHPUnit\Framework\TestCase;
use Sonata\Twig\Node\TemplateBoxNode;
use Sonata\Twig\TokenParser\TemplateBoxTokenParser;
use Symfony\Component\Translation\TranslatorInterface;

class TemplateBoxTokenParserTest extends TestCase
{
    /**
     * @dataProvider getTestsForRender
     *
     * @param bool            $enabled
     * @param \Twig_Source    $source
     * @param TemplateBoxNode $expected
     *
     * @throws \Twig_Error_Syntax
     */
    public function testCompile($enabled, $source, $expected): void
    {
        $translator = $this->createMock(TranslatorInterface::class);

        $env = new \Twig_Environment(new \Twig_Loader_Array([]), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $env->addTokenParser(new TemplateBoxTokenParser($enabled, $translator));
        if (class_exists('\Twig_Source')) {
            $source = new \Twig_Source($source, 'test');
        }
        $stream = $env->tokenize($source);
        $parser = new \Twig_Parser($env);

        $actual = $parser->parse($stream)->getNode('body')->getNode(0);
        $this->assertSame(
            $expected->getIterator()->getFlags(),
            $actual->getIterator()->getFlags()
        );
        $this->assertSame($expected->getTemplateLine(), $actual->getTemplateLine());
        $this->assertSame($expected->count(), $actual->count());
    }

    public function getTestsForRender()
    {
        return [
            [
                true,
                '{% sonata_template_box %}',
                new TemplateBoxNode(
                    new \Twig_Node_Expression_Constant('Template information', 1),
                    true,
                    1,
                    'sonata_template_box'
                ),
            ],
            [
                true,
                '{% sonata_template_box "This is the basket delivery address step page" %}',
                new TemplateBoxNode(
                    new \Twig_Node_Expression_Constant('This is the basket delivery address step page', 1),
                    true,
                    1,
                    'sonata_template_box'
                ),
            ],
            [
                false,
                '{% sonata_template_box "This is the basket delivery address step page" %}',
                new TemplateBoxNode(
                    new \Twig_Node_Expression_Constant('This is the basket delivery address step page', 1),
                    false,
                    1,
                    'sonata_template_box'
                ),
            ],
        ];
    }
}
