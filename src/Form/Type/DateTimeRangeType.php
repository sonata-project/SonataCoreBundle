<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;

class DateTimeRangeType extends AbstractType
{
    /**
     * NEXT_MAJOR: remove this property.
     *
     * @var TranslatorInterface|null
     *
     * @deprecated translator property is deprecated since version 3.1, to be removed in 4.0
     */
    protected $translator;

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated translator dependency is deprecated since version 3.1, to be removed in 4.0
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        // check if class is overloaded and notify about removing deprecated translator
        if (null !== $translator && __CLASS__ !== get_class($this) && DateTimeRangePickerType::class !== get_class($this)) {
            @trigger_error(
                'The translator dependency in '.__CLASS__.' is deprecated since 3.1 and will be removed in 4.0. '.
                'Please prepare your dependencies for this change.',
                E_USER_DEPRECATED
            );
        }

        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['field_options_start'] = array_merge(
            [
                'label' => 'date_range_start',
                'translation_domain' => 'SonataCoreBundle',
            ],
            $options['field_options_start']
        );

        $options['field_options_end'] = array_merge(
            [
                'label' => 'date_range_end',
                'translation_domain' => 'SonataCoreBundle',
            ],
            $options['field_options_end']
        );

        $builder->add('start', $options['field_type'], array_merge(['required' => false], $options['field_options'], $options['field_options_start']));
        $builder->add('end', $options['field_type'], array_merge(['required' => false], $options['field_options'], $options['field_options_end']));
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_datetime_range';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     *
     * @todo Remove it when bumping requirements to SF 2.7+
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field_options' => [],
            'field_options_start' => [],
            'field_options_end' => [],
            'field_type' => DateTimeType::class,
        ]);
    }
}
