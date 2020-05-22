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

namespace Sonata\Form\EventListener;

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
        /*
         * NEXT_MAJOR: change preBind to preSubmit and onBind to onSubmit
         */
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preBind',
            FormEvents::SUBMIT => 'onBind',
        ];
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since sonata-project/core-bundle 2.3, to be renamed in 4.0. Use {@link preSubmit} instead.
     */
    public function preBind(FormEvent $event)
    {
        $this->preSubmit($event);
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since sonata-project/core-bundle 2.3, to be removed in 4.0. Use {@link onSubmit} instead.
     */
    public function onBind(FormEvent $event)
    {
        $this->onSubmit($event);
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

        if (!\is_array($data) && !$data instanceof \Traversable) {
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

        if (!\is_array($data) && !$data instanceof \Traversable) {
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
                    $buildOptions['data'] = \call_user_func($this->preSubmitDataCallback, $value);
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

        if (!\is_array($data) && !$data instanceof \Traversable) {
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
