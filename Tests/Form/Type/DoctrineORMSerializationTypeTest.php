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

use Doctrine\ORM\Mapping\ClassMetadataInfo as DoctrineMetadata;
use JMS\Serializer\Metadata\ClassMetadata as SerializerMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType;
use Symfony\Component\Form\Forms;
use Symfony\Component\HttpKernel\Kernel;

class FakeMetadataClass
{
    protected $name;

    protected $url;

    protected $comments;
}

/**
 * @author Vincent Composieux <vincent.composieux@gmail.com>
 */
class DoctrineORMSerializationTypeTest extends TypeTestCase
{
    /**
     * @var string
     */
    protected $class;

    /**
     * Set up test.
     */
    public function setUp()
    {
        if (!interface_exists('\Metadata\MetadataFactoryInterface') or !interface_exists('\Doctrine\ORM\EntityManagerInterface')) {
            $this->markTestSkipped('Serializer and Doctrine has to be loaded to run this test');
        }

        parent::setUp();

        $this->class = 'Sonata\CoreBundle\Tests\Form\Type\FakeMetadataClass';
    }

    /**
     * Test form type buildForm() method that generates data.
     */
    public function testBuildForm()
    {
        $metadataFactory = $this->getMetadataFactoryMock();
        $registry = $this->getRegistryMock();

        if (version_compare(Kernel::VERSION, '2.8', '<')) {
            $type = new DoctrineORMSerializationType($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_write');
        } else {
            $this->factory = $this->createCustomFactory($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_write');
            $type = 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType';
        }

        $form = $this->factory->createBuilder($type, null)->setCompound(true)->getForm();

        // Asserts that all 3 elements are in the form
        $this->assertSame(3, $form->count(), 'Should return 3 items in form');

        // Assets that forms are correctly returned for correct fields
        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form->get('name'), 'Should return a form instance');
        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form->get('url'), 'Should return a form instance');
        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form->get('comments'), 'Should return a form instance');

        // Asserts that required fields / associations rules are correctly parsed
        $this->assertFalse($form->get('name')->isRequired(), 'Should return a non-required field');
        $this->assertTrue($form->get('url')->isRequired(), 'Should return a required field');
        $this->assertFalse($form->get('comments')->isRequired(), 'Should return a non-required field');
    }

    public function testBuildFormAddCall()
    {
        $formBuilder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $formBuilder
            ->expects($this->any())
            ->method('add')
            ->will($this->returnCallback(function ($name, $type = null) {
                if (null !== $type) {
                    $this->assertTrue(class_exists($type), sprintf('Unable to ensure %s is a FQCN', $type));
                }
            }));

        $type = new DoctrineORMSerializationType(
            $this->getMetadataFactoryMock(), // $this->createMock('Metadata\MetadataFactoryInterface'),
            $this->getRegistryMock(),
            'form_type_test',
            $this->class,
            'serialization_api_write'
        );

        $type->buildForm($formBuilder, []);
    }

    /**
     * Test form type buildForm() method that generates data with an identifier field.
     */
    public function testBuildFormWithIdentifier()
    {
        $metadataFactory = $this->getMetadataFactoryMock();
        $registry = $this->getRegistryMock(['name']);

        if (version_compare(Kernel::VERSION, '2.8', '<')) {
            $type = new DoctrineORMSerializationType($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_write');
        } else {
            $this->factory = $this->createCustomFactory($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_write');
            $type = 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType';
        }

        $form = $this->factory->createBuilder($type, null)->setCompound(true)->getForm();

        // Assets that forms have only 2 generated fields as the third is an identifier
        $this->assertSame(2, $form->count(), 'Should return 2 elements in the form');

        // Assets that forms are correctly returned for correct fields
        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form->get('url'), 'Should return a form instance');
        $this->assertInstanceOf('Symfony\Component\Form\FormInterface', $form->get('comments'), 'Should return a form instance');
    }

    /**
     * Test form type buildForm() method that generates data with an invalid group name.
     */
    public function testBuildFormWithInvalidGroupName()
    {
        $metadataFactory = $this->getMetadataFactoryMock();
        $registry = $this->getRegistryMock(['name']);

        if (version_compare(Kernel::VERSION, '2.8', '<')) {
            $type = new DoctrineORMSerializationType($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_invalid');
        } else {
            $this->factory = $this->createCustomFactory($metadataFactory, $registry, 'form_type_test', $this->class, 'serialization_api_invalid');
            $type = 'Sonata\CoreBundle\Form\Type\DoctrineORMSerializationType';
        }

        $form = $this->factory->createBuilder($type, null)->setCompound(true)->getForm();

        // Assets that forms have no generated field as group is invalid
        $this->assertSame(0, $form->count(), 'Should return 0 elements as given form type group is invalid');
    }

    public function testGetParent()
    {
        $form = new DoctrineORMSerializationType(
            $this->createMock('Metadata\MetadataFactoryInterface'),
            $this->createMock('Doctrine\Common\Persistence\ManagerRegistry'),
            'form_type_test',
            $this->class,
            'serialization_api_write'
        );

        $parentRef = $form->getParent();

        $this->assertTrue(class_exists($parentRef), sprintf('Unable to ensure %s is a FQCN', $parentRef));
    }

    /**
     * Returns a Serializer MetadataFactory mock.
     *
     * @return \Metadata\MetadataFactoryInterface
     */
    protected function getMetadataFactoryMock()
    {
        $name = new PropertyMetadata($this->class, 'name');
        $name->groups = ['serialization_api_write'];

        $url = new PropertyMetadata($this->class, 'url');
        $url->groups = ['serialization_api_write'];

        $comments = new PropertyMetadata($this->class, 'comments');
        $comments->groups = ['serialization_api_write'];

        $classMetadata = new SerializerMetadata($this->class);
        $classMetadata->addPropertyMetadata($name);
        $classMetadata->addPropertyMetadata($url);
        $classMetadata->addPropertyMetadata($comments);

        $metadataFactory = $this->createMock('Metadata\MetadataFactoryInterface');
        $metadataFactory->expects($this->once())->method('getMetadataForClass')->will($this->returnValue($classMetadata));

        return $metadataFactory;
    }

    /**
     * Returns a Doctrine registry mock.
     *
     * @param array $identifiers
     *
     * @return \Symfony\Bridge\Doctrine\RegistryInterface
     */
    protected function getRegistryMock($identifiers = [])
    {
        $classMetadata = new DoctrineMetadata($this->class);
        $classMetadata->identifier = $identifiers;

        $classMetadata->fieldMappings = ['name' => [
            'nullable' => true,
        ]];

        $classMetadata->associationMappings = [
            'url' => [
                'joinColumns' => ['nullable' => false],
            ],
            'comments' => [
                'inverseJoinColumns' => ['nullable' => true],
            ],
        ];

        $entityManager = $this->createMock('Doctrine\ORM\EntityManagerInterface');
        $entityManager->expects($this->once())->method('getClassMetadata')->will($this->returnValue($classMetadata));

        $registry = $this->createMock('Doctrine\Common\Persistence\ManagerRegistry');
        $registry->expects($this->once())->method('getManagerForClass')->will($this->returnValue($entityManager));

        return $registry;
    }

    /**
     * Create a form factory registering the DoctrineORMSerializationType.
     */
    protected function createCustomFactory($metadataFactory, $registry, $name, $class, $group)
    {
        return $this->factory = Forms::createFormFactoryBuilder()
            ->addType(new DoctrineORMSerializationType($metadataFactory, $registry, $name, $class, $group))
            ->getFormFactory();
    }
}
