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

namespace Sonata\Twig\Tests\Node;

use Sonata\Twig\Node\TemplateBoxNode;

class TemplateBoxNodeTest extends \Twig_Test_NodeTestCase
{
    public function testConstructor(): void
    {
        $body = new TemplateBoxNode(
            new \Twig_Node_Expression_Constant('This is the default message', 1),
            true,
            1,
            'sonata_template_box'
        );

        $this->assertSame(1, $body->getTemplateLine());
    }

    /**
     * @covers \Twig_Node_Block::compile
     * @dataProvider getTests
     */
    public function testCompile($node, $source, $environment = null, $isPattern = false): void
    {
        parent::testCompile($node, $source, $environment, $isPattern);
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        $nodeEn = new TemplateBoxNode(
            new \Twig_Node_Expression_Constant('This is the default message', 1),
            true,
            1,
            'sonata_template_box'
        );

        $nodeFr = new TemplateBoxNode(
            new \Twig_Node_Expression_Constant('Ceci est le message par défaut', 1),
            true,
            1,
            'sonata_template_box'
        );

        return [
            [$nodeEn, <<<'EOF'
// line 1
echo "<div class='alert alert-default alert-info'>
    <strong>This is the default message</strong>
    <div>This file can be found in <code>{$this->getTemplateName()}</code>.</div>
</div>";
EOF
            ],
            [$nodeFr, <<<'EOF'
// line 1
echo "<div class='alert alert-default alert-info'>
    <strong>Ceci est le message par défaut</strong>
    <div>This file can be found in <code>{$this->getTemplateName()}</code>.</div>
</div>";
EOF
            ],
        ];
    }
}
