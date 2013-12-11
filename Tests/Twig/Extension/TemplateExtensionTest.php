<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Twig\Extension;

use Sonata\CoreBundle\Twig\Extension\TemplateExtension;

class TemplateExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $extension = new TemplateExtension(true);

        $this->assertEquals($extension->slugify('test'), 'test');
        $this->assertEquals($extension->slugify('S§!@@#$#$alut'), 's-alut');
        $this->assertEquals($extension->slugify('Symfony2'), 'symfony2');
        $this->assertEquals($extension->slugify('test'), 'test');
        $this->assertEquals($extension->slugify('c\'est bientôt l\'été'), 'c-est-bientot-l-ete');
        $this->assertEquals($extension->slugify(urldecode('%2Fc\'est+bientôt+l\'été')), 'c-est-bientot-l-ete');
    }
}