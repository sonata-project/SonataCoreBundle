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

namespace Sonata\Twig\Tests\FlashMessage;

use PHPUnit\Framework\TestCase;
use Sonata\Twig\FlashMessage\FlashManager;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * @author Vincent Composieux <composieux@ekino.com>
 *
 * @group legacy
 */
class FlashManagerTest extends TestCase
{
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var FlashManager
     */
    protected $flashManager;

    /**
     * Set up units tests.
     */
    public function setUp(): void
    {
        $this->session = $this->getSession();
        $this->flashManager = $this->getFlashManager([
            'success' => [
                'my_bundle_success' => [],
                'my_second_bundle_success' => [],
            ],
            'warning' => [
                'my_bundle_warning' => [],
                'my_second_bundle_warning' => [],
            ],
            'error' => [
                'my_bundle_error' => [],
                'my_second_bundle_error' => [],
            ],
        ]);
    }

    /**
     * Test the flash manager getSession() method.
     */
    public function testGetSession(): void
    {
        // When
        $session = $this->flashManager->getSession();

        // Then
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testGetHandledTypes(): void
    {
        $this->assertSame(['success', 'warning', 'error'], $this->flashManager->getHandledTypes());
    }

    public function testGetStatus(): void
    {
        $this->assertSame('danger', $this->flashManager->getStatusClass('error'));
    }

    /**
     * Test the flash manager getTypes() method.
     */
    public function testGetTypes(): void
    {
        // When
        $types = $this->flashManager->getTypes();

        // Then
        $this->assertCount(3, $types);
        $this->assertSame([
            'success' => [
                'my_bundle_success' => [],
                'my_second_bundle_success' => [],
            ],
            'warning' => [
                'my_bundle_warning' => [],
                'my_second_bundle_warning' => [],
            ],
            'error' => [
                'my_bundle_error' => [],
                'my_second_bundle_error' => [],
            ],
        ], $types);
    }

    /**
     * Test the flash manager handle() method with registered types.
     */
    public function testHandlingRegisteredTypes(): void
    {
        // Given
        $this->session->getFlashBag()->set('my_bundle_success', 'hey, success dude!');
        $this->session->getFlashBag()->set('my_second_bundle_success', 'hey, success dude!');

        $this->session->getFlashBag()->set('my_bundle_warning', 'hey, warning dude!');
        $this->session->getFlashBag()->set('my_second_bundle_warning', 'hey, warning dude!');

        $this->session->getFlashBag()->set('my_bundle_error', 'hey, error dude!');
        $this->session->getFlashBag()->set('my_second_bundle_error', 'hey, error dude!');

        // When
        $successMessages = $this->flashManager->get('success');
        $warningMessages = $this->flashManager->get('warning');
        $errorMessages = $this->flashManager->get('error');

        // Then
        $this->assertCount(2, $successMessages);

        foreach ($successMessages as $message) {
            $this->assertSame($message, 'hey, success dude!');
        }

        $this->assertCount(2, $warningMessages);

        foreach ($warningMessages as $message) {
            $this->assertSame($message, 'hey, warning dude!');
        }

        $this->assertCount(2, $errorMessages);

        foreach ($errorMessages as $message) {
            $this->assertSame($message, 'hey, error dude!');
        }
    }

    /**
     * Test the flash manager handle() method with non-registered types.
     */
    public function testHandlingNonRegisteredTypes(): void
    {
        // Given
        $this->session->getFlashBag()->set('non_registered_success', 'hey, success dude!');

        // When
        $messages = $this->flashManager->get('success');
        $nonRegisteredMessages = $this->flashManager->get('non_registered_success');

        // Then
        $this->assertCount(0, $messages);

        $this->assertCount(1, $nonRegisteredMessages);

        foreach ($nonRegisteredMessages as $message) {
            $this->assertSame($message, 'hey, success dude!');
        }
    }

    /**
     * Test the flash manager get() method with a specified domain.
     */
    public function testFlashMessageWithCustomDomain(): void
    {
        // When
        $this->session->getFlashBag()->set('my_bundle_success', 'my_bundle_success_message');
        $messages = $this->flashManager->get('success');

        $this->session->getFlashBag()->set('my_bundle_success', 'my_bundle_success_message');
        $messagesWithoutDomain = $this->flashManager->get('success');

        // Then
        $this->assertCount(1, $messages);
        $this->assertCount(1, $messagesWithoutDomain);

        foreach ($messages as $message) {
            $this->assertSame($message, 'my_bundle_success_message');
        }

        foreach ($messagesWithoutDomain as $message) {
            $this->assertSame($message, 'my_bundle_success_message');
        }
    }

    /**
     * Returns a Symfony session service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSession()
    {
        return new Session(new MockArraySessionStorage(), new AttributeBag(), new FlashBag());
    }

    /**
     * Returns Sonata core flash manager.
     *
     * @param array $types
     *
     * @return FlashManager
     */
    protected function getFlashManager(array $types)
    {
        $classes = ['error' => 'danger'];

        return new FlashManager($this->session, $types, $classes);
    }
}
