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
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param bool $debug Is Symfony debug enabled?
     */
    public function __construct($debug, TranslatorInterface $translator, AdapterInterface $modelAdapter)
    {
        $this->debug = $debug;
        $this->translator = $translator;
        $this->modelAdapter = $modelAdapter;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('sonata_slugify', [$this, 'slugify'], ['deprecated' => true, 'alternative' => 'slugify']),
            new \Twig_SimpleFilter('sonata_urlsafeid', [$this, 'getUrlsafeIdentifier']),
        ];
    }

    public function getTokenParsers()
    {
        return [
            new TemplateBoxTokenParser($this->debug, $this->translator),
        ];
    }

    /**
     * Slugify a text.
     *
     * @return string
     */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        return $text;
    }

    /**
     * @return string
     */
    public function getUrlsafeIdentifier($model)
    {
        return $this->modelAdapter->getUrlsafeIdentifier($model);
    }

    public function getName()
    {
        return 'sonata_core_template';
    }
}
