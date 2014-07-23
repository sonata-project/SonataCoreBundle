<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\CoreBundle\Date;

use Sonata\CoreBundle\Exception\InvalidParameterException;


/**
 * Handles Moment.js <-> PHP date format conversion
 *
 * Inspired by https://github.com/fightbulc/moment.php/blob/master/src/Moment/CustomFormats/MomentJs.php
 *
 * @package Sonata\CoreBundle\Date
 *
 * @author Hugo Briand <briand@ekino.com>,
 */
class MomentFormatConverter
{
    /**
     * @var array This defines the mapping between PHP date format (key) and moment.js date format (value)
     */
    private $phpMomentMapping = array(
        "yyyy-MM-dd'T'HH:mm:ssZZZZZ" => 'YYYY-MM-DDTHH:mm:ssZZ', // 2014-05-14T13:55:01+02:00
        "Y-m-d\TH:i:sO"              => 'YYYY-MM-DDTHH:mm:ssZZ', // 2014-05-14T13:55:01+0200
        "dd.MM.yyyy, HH:mm"          => 'DD.MM.YYYY, HH:mm',     // german format without seconds: 14.05.2014, 13:55
        "d.m.Y, H:i"                 => 'DD.MM.YYYY, HH:mm',     // german format without seconds: 14.05.2014, 13:55
        "dd.MM.yyyy, HH:mm:ss"       => 'DD.MM.YYYY, HH:mm:ss',  // german format: 14.05.2014, 13:55:01
        "d.m.Y, H:i:s"               => 'DD.MM.YYYY, HH:mm:ss',  // german format: 14.05.2014, 13:55:01
        "yyyy-MM-dd"                 => 'YYYY-MM-DD',            // 2014-05-14
        "Y-m-d"                      => 'YYYY-MM-DD',            // 2014-05-14

        // 24 hour format
        'G:i'                        => 'H:mm',
        'G:i:s'                      => 'H:mm:ss',
        'H:i'                        => 'HH:mm',
        'H:i:s'                      => 'HH:mm:ss',

        // 12 hour format
        'g:i'                        => 'h:mm',
        'g:i:s'                      => 'h:mm:ss',
        "h:i"                        => 'hh:mm',
        "h:i:s"                      => 'hh:mm:ss',

        // am/pm suffix only makes sense with 12 hour format
        'g:i a'                      => 'h:mm a',
        'g:i:s a'                    => 'h:mm:ss a',

        'g:i A'                      => 'h:mm A',
        'g:i:s A'                    => 'h:mm:ss A',

        "h:i a"                      => 'hh:mm a',
        "h:i:s a"                    => 'hh:mm:ss a',

        "h:i A"                      => 'hh:mm A',
        "h:i:s A"                    => 'hh:mm:ss A',
    );

    /**
     * If $format is recognized, returns associated moment.js format, throws exception otherwise.
     *
     * @param $format PHP Date format
     *
     * @return string Moment.js date format
     * @throws \Sonata\CoreBundle\Exception\InvalidParameterException If format not found
     */
    public function convert($format)
    {
        if (!array_key_exists($format, $this->phpMomentMapping)) {
            throw new InvalidParameterException(sprintf("PHP Date format '%s' is not a convertible moment.js format; please add it to the 'Sonata\CoreBundle\Date\MomentFormatConverter' class by submitting a pull request if you want it supported.", $format));
        }

        return $this->phpMomentMapping[$format];
    }
}