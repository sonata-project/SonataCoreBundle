<?php

namespace Sonata\CoreBundle\Tests\FlashMessage;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

use Sonata\CoreBundle\FlashMessage\FlashManager;

/**
 * Class FlashManagerTest
 *
 * This is the FlashManager test class
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class FlashManagerTest extends \PHPUnit_Framework_TestCase
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
     * Set up units tests
     */
    public function setUp()
    {
        $this->session      = $this->getSession();
        $this->flashManager = $this->getFlashManager(array(
            'success' => array('my_bundle_success', 'my_second_bundle_success'),
            'warning' => array('my_bundle_warning', 'my_second_bundle_warning'),
            'error'   => array('my_bundle_error', 'my_second_bundle_error'),
        ));
    }

    /**
     * Test the flash manager getSession() method
     */
    public function testGetSession()
    {
        // When
        $session = $this->flashManager->getSession();

        // Then
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Session\Session', $session);
    }

    /**
     * Test the flash manager getTypes() method
     */
    public function testGetTypes()
    {
        // When
        $types = $this->flashManager->getTypes();

        // Then
        $this->assertCount(3, $types);
        $this->assertEquals(array(
            'success' => array('my_bundle_success', 'my_second_bundle_success'),
            'warning' => array('my_bundle_warning', 'my_second_bundle_warning'),
            'error'   => array('my_bundle_error', 'my_second_bundle_error'),
        ), $types);
    }

    /**
     * Test the flash manager handle() method with registered types
     */
    public function testHandlingRegisteredTypes()
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
            $this->assertEquals($message, 'hey, success dude!');
        }

        $this->assertCount(2, $warningMessages);

        foreach ($warningMessages as $message) {
            $this->assertEquals($message, 'hey, warning dude!');
        }

        $this->assertCount(2, $errorMessages);

        foreach ($errorMessages as $message) {
            $this->assertEquals($message, 'hey, error dude!');
        }
    }

    /**
     * Test the flash manager handle() method with non-registered types
     */
    public function testHandlingNonRegisteredTypes()
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
            $this->assertEquals($message, 'hey, success dude!');
        }
    }

    /**
     * Returns a Symfony session service
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    protected function getSession()
    {
        return new Session(new MockArraySessionStorage(), new AttributeBag(), new FlashBag());
    }

    /**
     * Returns Sonata core flash manager
     *
     * @param array $types
     *
     * @return FlashManager
     */
    protected function getFlashManager(array $types)
    {
        return new FlashManager($this->session, $types);
    }
}
