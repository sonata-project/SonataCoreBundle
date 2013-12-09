<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\FlashMessage;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class FlashManager
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class FlashManager
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var array
     */
    protected $types;

    /**
     * Constructor
     *
     * @param Session $session Symfony session service
     * @param array   $types   Sonata core types array (defined in configuration)
     */
    public function __construct(Session $session, array $types)
    {
        $this->session = $session;
        $this->types   = $types;
    }

    /**
     * Returns Sonata core flash message types
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Returns Symfony session service
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Returns flash bag messages for correct type after renaming with Sonata core type
     *
     * @param string $type
     *
     * @return array
     */
    public function get($type)
    {
        $this->handle();

        return $this->getSession()->getFlashBag()->get($type);
    }

    /**
     * Handles flash bag types renaming
     *
     * @return void
     */
    protected function handle()
    {
        foreach ($this->getTypes() as $type => $values) {
            foreach ($values as $value) {
                $this->rename($type, $value);
            }
        }
    }

    /**
     * Process flash message type rename
     *
     * @param string $type  Sonata core flash message type
     * @param string $value Original flash message type
     *
     * @return void
     */
    protected function rename($type, $value)
    {
        $flashBag = $this->getSession()->getFlashBag();

        foreach ($flashBag->get($value) as $message) {
            $flashBag->add($type, $message);
        }
    }
}
