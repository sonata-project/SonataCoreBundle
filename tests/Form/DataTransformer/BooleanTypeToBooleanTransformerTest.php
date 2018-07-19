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

namespace Sonata\CoreBundle\Tests\Form\DataTransformer;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Form\DataTransformer\BooleanTypeToBooleanTransformer;
use Sonata\CoreBundle\Form\Type\BooleanType;

class BooleanTypeToBooleanTransformerTest extends TestCase
{
    /**
     * @dataProvider getReverseTransformData
     */
    public function testReverseTransform($value, $expected): void
    {
        $transformer = new BooleanTypeToBooleanTransformer();

        $this->assertSame($expected, $transformer->transform($value));
    }

    public function testTransform(): void
    {
        $transformer = new BooleanTypeToBooleanTransformer();
        $this->assertTrue($transformer->reverseTransform(BooleanType::TYPE_YES));
        $this->assertTrue($transformer->reverseTransform(1));
        $this->assertFalse($transformer->reverseTransform(BooleanType::TYPE_NO));
        $this->assertFalse($transformer->reverseTransform(2));
        $this->assertNull($transformer->reverseTransform(null));
        $this->assertNull($transformer->reverseTransform('asd'));
    }

    public function getReverseTransformData()
    {
        return [
            [true, BooleanType::TYPE_YES],
            [false, BooleanType::TYPE_NO],
            ['wrong', null],
            ['1', BooleanType::TYPE_YES],
            ['2', BooleanType::TYPE_NO],
            ['3', null], // default value is null ...
        ];
    }
}
