<?php

/*
 * This file is part of sonata-project.
 *
 * (c) 2010 Thomas Rabaix
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Twig\Extension;

use Sonata\CoreBundle\Twig\TokenParser\TemplateBoxTokenParser;

class TemplateExtension extends \Twig_Extension
{
    protected $debug;

    /**
     * @param bool $debug
     */
    public function __construct($debug)
    {
        $this->debug = $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            'sonata_slugify' => new \Twig_Filter_Method($this, 'slugify'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            new TemplateBoxTokenParser($this->debug),
        );
    }

    /**
     * Slugify a text
     *
     * @param $text
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
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        return $text;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_core_template';
    }
}
