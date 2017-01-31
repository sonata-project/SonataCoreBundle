<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Tests\Form\Type;

use Sonata\CoreBundle\Test\AbstractWidgetTestCase;

/**
 * @author Christian Gripp <mail@core23.de>
 */
class FormChoiceWidgetTest extends AbstractWidgetTestCase
{
    public function testLabelRendering()
    {
        $choices = array('some', 'choices');
        if (!method_exists('Symfony\Component\Form\FormTypeInterface', 'setDefaultOptions')) {
            $choices = array_flip($choices);
        }

        $choice = $this->factory->create(
            $this->getChoiceClass(),
            null,
            $this->getDefaultOption() + array(
                'multiple' => true,
                'expanded' => true,
            ) + compact('choices')
        );

        $html = $this->renderWidget($choice->createView());

        $this->assertContains(
            '<div id="choice"><input type="checkbox" id="choice_0" name="choice[]" value="0" /><label for="choice_0">[trans]some[/trans]</label><input type="checkbox" id="choice_1" name="choice[]" value="1" /><label for="choice_1">[trans]choices[/trans]</label></div>',
            $this->cleanHtmlWhitespace($html)
        );
    }

    public function testDefaultValueRendering()
    {
        $choice = $this->factory->create(
            $this->getChoiceClass(),
            null,
            $this->getDefaultOption()
        );

        $html = $this->renderWidget($choice->createView());

        $this->assertContains(
            '<option value="" selected="selected">[trans]Choose an option[/trans]</option>',
            $this->cleanHtmlWhitespace($html)
        );
    }

    public function testRequiredIsDisabledForEmptyPlaceholder()
    {
        $choice = $this->factory->create(
            $this->getChoiceClass(),
            null,
            $this->getRequiredOption()
        );

        $html = $this->renderWidget($choice->createView());

        $this->assertNotContains(
            'required="required"',
            $this->cleanHtmlWhitespace($html)
        );
    }

    public function testRequiredIsEnabledIfPlaceholderIsSet()
    {
        $choice = $this->factory->create(
            $this->getChoiceClass(),
            null,
            array_merge($this->getRequiredOption(), $this->getDefaultOption())
        );

        $html = $this->renderWidget($choice->createView());

        $this->assertContains(
            'required="required"',
            $this->cleanHtmlWhitespace($html)
        );
    }

    private function getRequiredOption()
    {
        return array(
            'required' => true,
        );
    }

    private function getChoiceClass()
    {
        return 'Symfony\Component\Form\Extension\Core\Type\ChoiceType';
    }

    private function getDefaultOption()
    {
        return array(
            'placeholder' => 'Choose an option',
        );
    }
}
