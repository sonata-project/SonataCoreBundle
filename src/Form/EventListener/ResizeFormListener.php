<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Resize a collection form element based on the data sent from the client.
 *
 * @author Bernhard Schussek <bernhard.schussek@symfony-project.com>
 */
class ResizeFormListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $resizeOnSubmit;

    /**
     * @var array
     */
    private $typeOptions;

    /**
     * @var string[]
     */
    private $removed = [];

    /**
     * @var \Closure
     */
    private $preSubmitDataCallback;

    /**
     * @param string        $type
     * @param bool          $resizeOnSubmit
     * @param \Closure|null $preSubmitDataCallback
     */
    public function __construct(
        $type,
        array $typeOptions = [],
        $resizeOnSubmit = false,
        $preSubmitDataCallback = null
    ) {
        $this->type = $type;
        $this->resizeOnSubmit = $resizeOnSubmit;
        $this->typeOptions = $typeOptions;
        $this->preSubmitDataCallback = $preSubmitDataCallback;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            // NEXT_MAJOR: change `preBind` to `preSubmit`
            FormEvents::PRE_SUBMIT => 'preBind',
            // NEXT_MAJOR: change `onBind` to `onSubmit`
            FormEvents::SUBMIT => 'onBind',
        ];
    }

    /**
     * @throws UnexpectedTypeException
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data) {
            $data = [];
        }

        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new UnexpectedTypeException($data, 'array or \Traversable');
        }

        // First remove all rows except for the prototype row
        foreach ($form as $name => $child) {
            $form->remove($name);
        }

        // Then add all rows again in the correct order
        foreach ($data as $name => $value) {
            $options = array_merge($this->typeOptions, [
                'property_path' => '['.$name.']',
                'data' => $value,
            ]);

            $form->add($name, $this->type, $options);
        }
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated Since version 2.3, to be renamed in 4.0.
     *             Use {@link preSubmit} instead
     */
    public function preBind(FormEvent $event)
    {
        // BC prevention for class extending this one.
        if (self::class !== get_called_class()) {
            @trigger_error(
                __METHOD__.' method is deprecated since 2.3 and will be renamed in 4.0.'
                .' Use '.__CLASS__.'::preSubmit instead.',
                E_USER_DEPRECATED
            );
        }

        $this->preSubmit($event);
    }

    /**
     * @throws UnexpectedTypeException
     */
    public function preSubmit(FormEvent $event)
    {
        if (!$this->resizeOnSubmit) {
            return;
        }

        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data || '' === $data) {
            $data = [];
        }

        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new UnexpectedTypeException($data, 'array or \Traversable');
        }

        // Remove all empty rows except for the prototype row
        foreach ($form as $name => $child) {
            $form->remove($name);
        }

        // Add all additional rows
        foreach ($data as $name => $value) {
            if (!$form->has($name)) {
                $buildOptions = [
                    'property_path' => '['.$name.']',
                ];

                if ($this->preSubmitDataCallback) {
                    $buildOptions['data'] = call_user_func($this->preSubmitDataCallback, $value);
                }

                $options = array_merge($this->typeOptions, $buildOptions);

                $form->add($name, $this->type, $options);
            }

            if (isset($value['_delete'])) {
                $this->removed[] = $name;
            }
        }
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated Since version 2.3, to be removed in 4.0.
     *             Use {@link onSubmit} instead
     */
    public function onBind(FormEvent $event)
    {
        // BC prevention for class extending this one.
        if (self::class !== get_called_class()) {
            @trigger_error(
                __METHOD__.' is deprecated since 2.3 and will be renamed in 4.0.'
                .' Use '.__CLASS__.'::onSubmit instead.',
                E_USER_DEPRECATED
            );
        }

        $this->onSubmit($event);
    }

    /**
     * @throws UnexpectedTypeException
     */
    public function onSubmit(FormEvent $event)
    {
        if (!$this->resizeOnSubmit) {
            return;
        }

        $form = $event->getForm();
        $data = $event->getData();

        if (null === $data) {
            $data = [];
        }

        if (!is_array($data) && !$data instanceof \Traversable) {
            throw new UnexpectedTypeException($data, 'array or \Traversable');
        }

        foreach ($data as $name => $child) {
            if (!$form->has($name)) {
                unset($data[$name]);
            }
        }

        // remove selected elements
        foreach ($this->removed as $pos) {
            unset($data[$pos]);
        }

        $event->setData($data);
    }
}
