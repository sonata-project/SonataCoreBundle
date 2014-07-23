<?php
/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Sonata\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Class DatePickerType
 *
 * @package Sonata\CoreBundle\Form\Type
 *
 * @author Hussein Jafferjee <hussein@jafferjee.ca>
 */
class TimePickerType extends BasePickerType
{
    const FORMAT = 'h:i:s A';

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array_merge($this->getCommonDefaults(), array(
            'model_timezone' => null,
            'view_timezone'  => null,
            'time_format'    => $this->getDefaultFormat(),
            'dp_pick_date'   => false,
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new DateTimeToStringTransformer($options['model_timezone'], $options['view_timezone'], $options['time_format'], false));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $format = $options['time_format'];

        // figure out use_seconds based on format
        $options['dp_use_seconds'] = strpos($format, 's') !== false;

        // we override format so BasePickerType properly formats the time
        $options['format'] = $format;

        parent::finishView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonata_type_time_picker';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormat()
    {
        return self::FORMAT;
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return 'text';
    }
}