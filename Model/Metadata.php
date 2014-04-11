<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\CoreBundle\Model;


/**
 * Class Metadata
 *
 * @package Sonata\CoreBundle\Model
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class Metadata implements MetadataInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var mixed
     */
    protected $image;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @param string $title
     * @param string $description
     * @param mixed  $image
     * @param string $domain
     */
    public function __construct($title, $description, $image, $domain = "")
    {
        $this->title       = $title;
        $this->description = $description;
        $this->image       = $image;
        $this->domain      = $domain;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}