<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Twig\TokenParser;

use Sonata\CoreBundle\Twig\Node\TemplateBoxNode;

class TemplateBoxNodeTest extends \Twig_Test_NodeTestCase
{
    public function testConstructor()
    {
        $body = new TemplateBoxNode(new \Twig_Node_Expression_Constant('This is the default message', 1), true, 1, 'sonata_template_box');
        $this->assertEquals(1, $body->getLine());
    }

    /**
     * @covers Twig_Node_Block::compile
     * @dataProvider getTests
     */
    public function testCompile($node, $source, $environment = null)
    {
        parent::testCompile($node, $source, $environment);
    }

    public function getTests()
    {
        $node = new TemplateBoxNode(new \Twig_Node_Expression_Constant('This is the default message', 1), true, 1, 'sonata_template_box');

        return array(
            array($node, <<<EOF
// line 1
echo "<div class='alert alert-default alert-info'>
    <strong>This is the default message</strong>
    <div>This file can be found in <code>{\$this->getTemplateName()}</code>.</div>
</div>";
EOF
            ),
        );
    }
}