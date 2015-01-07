<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateRangeType extends AbstractType
{
    protected $translator;

    /**
     * @param \Symfony\Component\Translation\TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $labelStart = isset($options['field_options']['label_start']) ? $options['field_options']['label_start'] : $options['label_start'];
        $labelEnd   = isset($options['field_options']['label_end']) ? $options['field_options']['label_end'] : $options['label_end'];

        unset($options['field_options']['label_start']);
        unset($options['field_options']['label_end']);
        
        $builder->add('start', $options['field_type'], array_merge(array('required' => false, 'label' => $labelStart), $options['field_options']));
        $builder->add('end', $options['field_type'], array_merge(array('required' => false, 'label' => $labelEnd), $options['field_options']));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sonata_type_date_range';
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'field_options'    => array(),
            'field_type'       => 'date',
            'label_start'      => $this->translator->trans('start'),
            'label_end'        => $this->translator->trans('end')
        ));
    }
}
