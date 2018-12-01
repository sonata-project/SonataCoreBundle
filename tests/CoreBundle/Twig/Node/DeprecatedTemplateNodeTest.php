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

namespace Sonata\CoreBundle\Tests\Twig\Node;

use Sonata\CoreBundle\Twig\Node\DeprecatedTemplateNode;
use Twig\Node\Expression\ConstantExpression;
use Twig\Test\NodeTestCase;

/**
 * @author Marko Kunic <kunicmarko20@gmail.com>
 */
class DeprecatedTemplateNodeTest extends NodeTestCase
{
    public function testConstructor(): void
    {
        $body = $this->getNode();

        $this->assertSame(1, $body->getTemplateLine());
    }

    /**
     * @expectedDeprecation The "" template is deprecated. Use "new.html.twig" instead.
     * @group legacy
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
        return [
            [$this->getNode(), null],
        ];
    }

    private function getNode()
    {
        return new DeprecatedTemplateNode(
            new ConstantExpression('new.html.twig', 1),
            1,
            'sonata_template_deprecate'
        );
    }
}
