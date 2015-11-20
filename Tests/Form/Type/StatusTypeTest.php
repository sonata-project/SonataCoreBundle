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

use Sonata\CoreBundle\Form\Type\StatusType;
use Sonata\CoreBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Choice
{
    public static function getList()
    {
        return array(
            1 => 'salut',
        );
    }
}

class StatusTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $type = new StatusType('Sonata\CoreBundle\Tests\Form\Type\Choice', 'getList', 'choice_type');

        $this->assertEquals('choice_type', $type->getName());
        $this->assertEquals(LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\ChoiceType'), $type->getParent());

        $optionResolver = new OptionsResolver();

        if (LegacyFormHelper::isLegacy()) {
            $type->setDefaultOptions($optionResolver);
        } else {
            $type->configureOptions($optionResolver);
        }

        $options = $optionResolver->resolve(array());

        $this->assertArrayHasKey('choices', $options);
        $this->assertEquals($options['choices'], array(1 => 'salut'));
    }
}
