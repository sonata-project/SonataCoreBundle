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

class TemplateExtension extends \Twig_Extension
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
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param bool                $debug        Is Symfony debug enabled?
     * @param TranslatorInterface $translator   Symfony Translator service
     * @param AdapterInterface    $modelAdapter A Sonata model adapter
     */
    public function __construct($debug, TranslatorInterface $translator, AdapterInterface $modelAdapter)
    {
        $this->debug = $debug;
        $this->translator = $translator;
        $this->modelAdapter = $modelAdapter;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sonata_urlsafeid', array($this, 'getUrlsafeIdentifier')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new TemplateBoxTokenParser($this->debug, $this->translator),
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
