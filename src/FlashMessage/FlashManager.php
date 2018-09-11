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

namespace Sonata\CoreBundle\FlashMessage;

use Sonata\CoreBundle\Component\Status\StatusClassRendererInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

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
    public function __construct(
        SessionInterface $session,
        TranslatorInterface $translator,
        array $types,
        array $cssClasses
    ) {
        $this->session = $session;
        $this->translator = $translator;
        $this->types = $types;
        $this->cssClasses = $cssClasses;
    }

    public function handlesObject($object, ?string $statusName = null): bool
    {
        return \is_string($object) && array_key_exists($object, $this->cssClasses);
    }

    public function getStatusClass($object, ?string $statusName = null, string $default = ''): string
    {
        return array_key_exists($object, $this->cssClasses)
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
     * Returns Symfony translator service.
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * Returns flash bag messages for correct type after renaming with Sonata core type.
     */
    public function get(string $type, ?string $domain = null): array
    {
        $this->handle($domain);

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
    private function handle(string $domain = null): void
    {
        foreach ($this->getTypes() as $type => $values) {
            foreach ($values as $value => $options) {
                $domainType = $domain ?: $options['domain'];
                $this->rename($type, $value, $domainType);
            }
        }
    }

    /**
     * Process flash message type rename.
     *
     * @param string $type   Sonata core flash message type
     * @param string $value  Original flash message type
     * @param string $domain Translation domain to use
     */
    private function rename(string $type, string $value, string $domain): void
    {
        $flashBag = $this->getSession()->getFlashBag();

        foreach ($flashBag->get($value) as $message) {
            $message = $this->getTranslator()->trans($message, [], $domain);
            $flashBag->add($type, $message);
        }
    }
}
