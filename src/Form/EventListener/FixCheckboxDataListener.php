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
use Symfony\Component\Form\Extension\Core\DataTransformer\BooleanToStringTransformer;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Using BooleanToStringTransform in a checkbox form type
 * will set false value to '0' instead of null which will end up
 * returning true value when the form is bind.
 *
 * @author Sylvain Rascar <rascar.sylvain@gmail.com>
 */
final class FixCheckboxDataListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SUBMIT => 'preSubmit'];
    }

    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $transformers = $event->getForm()->getConfig()->getViewTransformers();

        if (1 === \count($transformers) && $transformers[0] instanceof BooleanToStringTransformer && '0' === $data) {
            $event->setData(null);
        }
    }
}
