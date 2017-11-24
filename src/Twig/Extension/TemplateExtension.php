<?php

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
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;

class TemplateExtension extends AbstractExtension
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
    public function __construct($debug, AdapterInterface $modelAdapter)
    {
        $this->debug = $debug;
        $this->modelAdapter = $modelAdapter;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('sonata_urlsafeid', [$this, 'getUrlsafeIdentifier']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new TemplateBoxTokenParser($this->debug),
        ];
    }

    /**
     * @param $model
     *
     * @return string
     */
    public function getUrlsafeIdentifier($model)
    {
        return $this->modelAdapter->getUrlsafeIdentifier($model);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_core_template';
    }
}
