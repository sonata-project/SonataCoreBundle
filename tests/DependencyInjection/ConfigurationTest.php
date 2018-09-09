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

namespace Sonata\CoreBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    public function getConfiguration()
    {
        return new Configuration();
    }

    public function testInvalidFormTypeValueLeadsToErrorMessage(): void
    {
        $this->assertConfigurationIsInvalid(
            [
                ['form_type' => '3D'],
            ],
            'The form_type option value must be one of'
        );
    }

    public function testProcessedConfigurationLooksAsExpected(): void
    {
        $this->assertProcessedConfigurationEquals([
            ['form_type' => 'horizontal'], // this should be overwritten
            ['form_type' => 'standard'],    // by this during the merge
        ], [
            'form_type' => 'standard',
            'flashmessage' => [],
            'form' => [
                'mapping' => [
                    'enabled' => true,
                    'type' => [],
                    'extension' => [],
                ],
            ],
            'serializer' => [
                'formats' => ['json', 'xml', 'yml'],
            ],
        ]);
    }

    public function testFormMapping(): void
    {
        $this->assertProcessedConfigurationEquals([
            ['form' => [
                'mapping' => [
                    'type' => [
                        'foo' => 'Foo\Bar',
                    ],
                    'extension' => [
                        'choice' => [
                            'service.id',
                        ],
                    ],
                ],
            ]],
        ], [
            'form' => [
                'mapping' => [
                    'enabled' => true,
                    'type' => [
                        'foo' => 'Foo\Bar',
                    ],
                    'extension' => [
                        'choice' => [
                            'service.id',
                        ],
                    ],
                ],
            ],
            'form_type' => 'standard',
            'flashmessage' => [],
            'serializer' => [
                'formats' => ['json', 'xml', 'yml'],
            ],
        ]);
    }

    public function testDefault(): void
    {
        $this->assertProcessedConfigurationEquals([
            [],
        ], [
            'form' => [
                'mapping' => [
                    'enabled' => true,
                    'type' => [],
                    'extension' => [],
                ],
            ],
            'form_type' => 'standard',
            'flashmessage' => [],
            'serializer' => [
                'formats' => ['json', 'xml', 'yml'],
            ],
        ]);
    }
}
