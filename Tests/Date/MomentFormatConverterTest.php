<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\CoreBundle\Tests\Date;

use Sonata\CoreBundle\Date\MomentFormatConverter;


/**
 * Class MomentFormatConverterTest
 *
 * @package Sonata\CoreBundle\Tests\Date
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class MomentFormatConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testPhpToMoment()
    {
        $mfc = new MomentFormatConverter();

        $phpFormat = "Y-m-d\TH:i:sO";
        $this->assertEquals("YYYY-MM-DDTHH:mm:ssZZ", $mfc->convert($phpFormat));
        
        $phpFormat = "d.m.Y, H:i";
        $this->assertEquals("DD.MM.YYYY, HH:mm", $mfc->convert($phpFormat));
        
        $phpFormat = "d.m.Y, H:i:s";
        $this->assertEquals("DD.MM.YYYY, HH:mm:ss", $mfc->convert($phpFormat));
    }

    /**
     * @expectedException        Sonata\CoreBundle\Exception\InvalidParameterException
     * @expectedExceptionMessage PHP Date format 'unexisting format' is not a convertible moment.js format; please add it to the 'Sonata\CoreBundle\Date\MomentFormatConverter' class by submitting a pull request if you want it supported.
     */
    public function testPhpToMomentUnsupported()
    {
        $mfc = new MomentFormatConverter();
        $unexistingFormat = "unexisting format";

        $mfc->convert($unexistingFormat);
    }
}
