<?php

declare(strict_types=1);

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
use Sonata\CoreBundle\Form\FormHelper;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigInterface;

class FormHelperTest extends TestCase
{
    public function testRemoveFields()
    {
        $dataMapper = $this->createMock(DataMapperInterface::class);

        $config = $this->createMock(FormConfigInterface::class);
        $config->expects($this->any())->method('getName')->will($this->returnValue('root'));
        $config->expects($this->any())->method('getCompound')->will($this->returnValue(true));
        $config->expects($this->any())->method('getDataMapper')->will($this->returnValue($dataMapper));

        $form = new Form($config);

        $config = $this->createMock(FormConfigInterface::class);
        $config->expects($this->any())->method('getName')->will($this->returnValue('child'));

        $form->add(new Form($config));

        FormHelper::removeFields([], $form);

        $this->assertFalse(isset($form['child']));
    }
}
