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

use Sonata\CoreBundle\Form\FormHelper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EqualTypeTest extends TypeTestCase
{
    public function testGetDefaultOptions()
    {
        $type = new EqualType($this->getMock('Symfony\Component\Translation\TranslatorInterface'));

        $this->assertEquals('sonata_type_equal', $type->getName());
        $this->assertEquals(
            method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix') ?
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType' :
                'choice',
            $type->getParent()
        );

        FormHelper::configureOptions($type, $resolver = new OptionsResolver());

        $options = $resolver->resolve();

        $expected = array(
            'choices' => array(1 => null, 2 => null),
        );

        $this->assertEquals($expected, $options);
    }
}
