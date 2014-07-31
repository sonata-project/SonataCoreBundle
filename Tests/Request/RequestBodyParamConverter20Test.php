<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Request;

use Sonata\CoreBundle\Request\RequestBodyParamConverter20;
use Symfony\Component\HttpFoundation\Request;

abstract class MyAbstractModel20 {

}

class MyModel20 extends MyAbstractModel20 {

}

class MyInvalidModel20 {

}

/**
 * Class RequestBodyParamConverterTest
 *
 * This is the test class of the request body param converter used to retrieve non-abstract model
 * classes used in bundles configuration
 *
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class RequestBodyParamConverter20Test extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // skip the test if the installed version of SensioFrameworkExtraBundle
        // is not compatible with the RequestBodyParamConverter20 class
        $parameter = new \ReflectionParameter(array(
            'Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface',
            'supports',
        ), 'configuration' );

        if ('Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface' != $parameter->getClass()->getName()) {
            $this->markTestSkipped('skipping RequestBodyParamConverter20Test due to an incompatible version of the SensioFrameworkExtraBundle');
        }
    }

    /**
     * Tests the apply() method
     *
     * Should return correct non-abstract class
     */
    public function testApply()
    {
        // Given
        $request = new Request();
        $serializer = $this->getMock('JMS\Serializer\SerializerInterface');

        $configuration = $this->getMock('Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface');

        $classes = array('Sonata\CoreBundle\Tests\Request\MyModel20');

        $service = new RequestBodyParamConverter20($serializer, null, null, null, null, $classes);

        // When
        $service->apply($request, $configuration);
    }

    /**
     * Tests the apply() method with an invalid class
     *
     * Should not alter the configuration class and return the model (abstract) class
     */
    public function testApplyInvalidClass()
    {
        // Given
        $request = new Request();
        $serializer = $this->getMock('JMS\Serializer\SerializerInterface');

        $configuration = $this->getMock('Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface');

        $classes = array('Sonata\CoreBundle\Tests\Request\MyInvalidModel20');

        $service = new RequestBodyParamConverter20($serializer, null, null, null, null, $classes);

        // When
        $service->apply($request, $configuration);

        // Then
        $this->assertEquals('Sonata\CoreBundle\Tests\Request\MyAbstractModel20', $configuration->getClass());
    }
}
