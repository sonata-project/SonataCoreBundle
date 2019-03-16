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

namespace Sonata\Twig\FlashMessage;

use Sonata\Twig\Status\StatusClassRendererInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @author Vincent Composieux <composieux@ekino.com>
 */
final class FlashManager implements StatusClassRendererInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var array
     */
    private $types;

    /**
     * @var array
     */
    private $cssClasses;

    /**
     * @param array $types      Sonata core types array (defined in configuration)
     * @param array $cssClasses Css classes associated with $types
     */
    public function __construct(SessionInterface $session, array $types, array $cssClasses)
    {
        $this->session = $session;
        $this->types = $types;
        $this->cssClasses = $cssClasses;
    }

    public function handlesObject($object, ?string $statusName = null): bool
    {
        return \is_string($object) && \array_key_exists($object, $this->cssClasses);
    }

    public function getStatusClass($object, ?string $statusName = null, string $default = ''): string
    {
        return \array_key_exists($object, $this->cssClasses)
            ? $this->cssClasses[$object]
            : $default;
    }

    /**
     * Returns Sonata core flash message types.
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Returns Symfony session service.
     */
    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    /**
     * Returns flash bag messages for correct type after renaming with Sonata core type.
     */
    public function get(string $type): array
    {
        $this->handle();

        return $this->getSession()->getFlashBag()->get($type);
    }

    /**
     * Gets handled message types.
     */
    public function getHandledTypes(): array
    {
        return array_keys($this->getTypes());
    }

    /**
     * Handles flash bag types renaming.
     */
    private function handle(): void
    {
        foreach ($this->getTypes() as $type => $values) {
            foreach ($values as $value => $options) {
                $this->rename($type, $value);
            }
        }
    }

    /**
     * Process flash message type rename.
     *
     * @param string $type  Sonata core flash message type
     * @param string $value Original flash message type
     */
    private function rename(string $type, string $value): void
    {
        $flashBag = $this->getSession()->getFlashBag();

        foreach ($flashBag->get($value) as $message) {
            $flashBag->add($type, $message);
        }
    }
}
