<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EqualTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $type = new EqualType($this->getMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertEquals('sonata_type_equal', $type->getName());
        $this->assertEquals(LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\ChoiceType'), $type->getParent());

        $optionResolver = new OptionsResolver();
        if (LegacyFormHelper::isLegacy()) {
            $type->setDefaultOptions($optionResolver);
        } else {
            $type->configureOptions($optionResolver);
        }

        $options = $optionResolver->resolve();

        $expected = array(
            'choices' => array(1 => null, 2 => null),
        );

        $this->assertEquals($expected, $options);
    }
}
