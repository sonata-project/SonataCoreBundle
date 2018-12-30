<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Model\Metadata;

/**
 * @author Hugo Briand <briand@ekino.com>
 *
 * @group legacy
 */
class MetadataTest extends TestCase
{
    public function testGetters()
    {
        $metadata = new Metadata('title', 'description', 'image', 'domain', ['key1' => 'value1']);

        $this->assertSame('title', $metadata->getTitle());
        $this->assertSame('description', $metadata->getDescription());
        $this->assertSame('image', $metadata->getImage());
        $this->assertSame('domain', $metadata->getDomain());

        $this->assertSame('value1', $metadata->getOption('key1'));
        $this->assertSame('valueDefault', $metadata->getOption('none', 'valueDefault'));
        $this->assertNull($metadata->getOption('none'));
        $this->assertSame(['key1' => 'value1'], $metadata->getOptions());

        $metadata->setOption('key2', 'value2');

        $this->assertSame('value2', $metadata->getOption('key2'));
        $this->assertSame(['key1' => 'value1', 'key2' => 'value2'], $metadata->getOptions());

        $metadata2 = new Metadata('title', 'description', 'image');
        $this->assertNull($metadata2->getDomain());
        $this->assertSame([], $metadata2->getOptions());
    }

    public function testImageNullGetDefaultImage()
    {
        $metadata = new Metadata('title', 'description');
        $this->assertSame($metadata->getImage(), $metadata::DEFAULT_MOSAIC_BACKGROUND);
    }

    public function testImageFalseDisableDefaultImage()
    {
        $metadata = new Metadata('title', 'description', false);
        $this->assertFalse($metadata->getImage());
    }

    /**
     * @dataProvider isImageAvailableProvider
     */
    public function testIsImageAvailable($expected, $image)
    {
        $this->assertEquals(
            $expected,
            (new Metadata('title', 'description', $image))->isImageAvailable()
        );
    }

    public function isImageAvailableProvider()
    {
        return [
            'image is null' => [false, null],
            'image is false' => [false, false],
            'image is available' => [true, 'image.png']
        ];
    }
}
