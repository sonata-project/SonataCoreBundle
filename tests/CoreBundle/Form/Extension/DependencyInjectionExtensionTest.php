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

namespace Sonata\CoreBundle\Tests\Form\Extension;

use PHPUnit\Framework\TestCase;
use Sonata\CoreBundle\Form\Extension\DependencyInjectionExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormTypeInterface;

class DependencyInjectionExtensionTest extends TestCase
{
    public function testValidType()
    {
        $type = $this->createMock(FormTypeInterface::class);
        $formName = \get_class($type);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->any())->method('has')->will($this->returnValue(true));
        $container->expects($this->any())
            ->method('get')
            ->with($this->equalTo($formName))
            ->will($this->returnValue($type));

        $f = new DependencyInjectionExtension(
            $container,
            [$formName => $formName], // typeServiceIds
            [], // typeExtensionServiceIds
            [], // guesserServiceids
            ['form' => $formName], //mappingTypes
            [] // extensionTypes
        );

        $f->getType('form');
        $f->getType($formName);
    }

    public function testTypeWithoutService()
    {
        $container = $this->createMock(ContainerInterface::class);

        $f = new DependencyInjectionExtension($container, [], [], [], []);

        $this->assertInstanceOf(HiddenType::class, $f->getType(HiddenType::class));
    }

    public function testTypeExtensionsValid()
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->any())->method('has')->will($this->returnValue(true));
        $container->expects($this->any())
            ->method('get')
            ->withConsecutive(
                [$this->equalTo('symfony.form.type.form_extension')],
                [$this->equalTo('sonata.form.type.form_extension')]
            )
        ;

        $typeServiceIds = [];
        $typeExtensionServiceIds = [
            FormType::class => [
                'symfony.form.type.form_extension',
            ],
        ];
        $guesserServiceIds = [];
        $mappingTypes = [
            'form' => FormType::class,
        ];
        $extensionTypes = [
            'form' => [
                'sonata.form.type.form_extension',
            ],
        ];

        $f = new DependencyInjectionExtension($container, $typeServiceIds, $typeExtensionServiceIds, $guesserServiceIds, $mappingTypes, $extensionTypes);

        $this->assertCount(2, $f->getTypeExtensions(FormType::class));
    }
}
