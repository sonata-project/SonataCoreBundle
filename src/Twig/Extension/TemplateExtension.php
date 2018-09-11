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

namespace Sonata\CoreBundle\Twig\Extension;

use Sonata\CoreBundle\Model\Adapter\AdapterInterface;
use Sonata\CoreBundle\Twig\TokenParser\TemplateBoxTokenParser;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class TemplateExtension extends AbstractExtension
{
    /**
     * @var bool
     */
    protected $debug;

    /**
     * @var AdapterInterface
     */
    protected $modelAdapter;

    /**
     * @param bool             $debug        Is Symfony debug enabled?
     * @param AdapterInterface $modelAdapter A Sonata model adapter
     */
    public function __construct(bool $debug, AdapterInterface $modelAdapter)
    {
        $this->debug = $debug;
        $this->modelAdapter = $modelAdapter;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sonata_urlsafeid', [$this, 'getUrlsafeIdentifier']),
        ];
    }

    public function getTokenParsers(): array
    {
        return [
            new TemplateBoxTokenParser($this->debug),
        ];
    }

    /**
     * @param object $model
     */
    public function getUrlsafeIdentifier($model): ?string
    {
        return $this->modelAdapter->getUrlsafeIdentifier($model);
    }

    public function getName(): string
    {
        return 'sonata_core_template';
    }
}
