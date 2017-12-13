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

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Date\MomentFormatConverter;
use Sonata\CoreBundle\Form\Type\BasePickerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Translation\TranslatorInterface;

class BasePickerTest extends BasePickerType
{
    public function getName()
    {
        return 'base_picker_test';
    }

    protected function getDefaultFormat()
    {
        return DateTimeType::HTML5_FORMAT;
    }
}

/**
 * @author Hugo Briand <briand@ekino.com>
 */
class BasePickerTypeTest extends TestCase
{
    public function testFinishView()
    {
        $type = new BasePickerTest(
            new MomentFormatConverter(),
            $this->createMock(TranslatorInterface::class)
        );

        $view = new FormView();
        $form = new Form($this->createMock(FormConfigInterface::class));

        $type->finishView($view, $form, ['format' => 'yyyy-MM-dd']);

        $this->assertArrayHasKey('moment_format', $view->vars);
        $this->assertArrayHasKey('dp_options', $view->vars);
        $this->assertArrayHasKey('datepicker_use_button', $view->vars);

        foreach ($view->vars['dp_options'] as $dpKey => $dpValue) {
            $this->assertFalse(strpos($dpKey, '_'));
            $this->assertFalse(strpos($dpKey, 'dp_'));
        }

        $this->assertSame('text', $view->vars['type']);
    }

    /**
     * NEXT_MAJOR: remove this test.
     *
     * @group legacy
     */
    public function testConstructorLegacy()
    {
        new BasePickerTest(new MomentFormatConverter());
    }
}
