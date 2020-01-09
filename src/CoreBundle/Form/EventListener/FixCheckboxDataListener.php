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

namespace Sonata\CoreBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

@trigger_error(
    'The '.__NAMESPACE__.'\FixCheckboxDataListener class is deprecated since version 3.13.0 and will be removed in 4.0.'
    .' Use Sonata\Form\EventListener\FixCheckboxDataListener instead.',
    E_USER_DEPRECATED
);

/**
 * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
 */
class FixCheckboxDataListener extends \Sonata\Form\EventListener\FixCheckboxDataListener
{
    public static function getSubscribedEvents()
    {
        return [FormEvents::PRE_SUBMIT => 'preBind'];
    }

    /**
     * NEXT_MAJOR: remove this method.
     *
     * @deprecated since sonata-project/core-bundle 2.3, to be renamed in 4.0.
     *             Use {@link preSubmit} instead
     */
    public function preBind(FormEvent $event)
    {
        // BC prevention for class extending this one.
        if (self::class !== \get_called_class()) {
            @trigger_error(
                __METHOD__.' is deprecated since 2.3 and will be renamed in 4.0.'
                .' Use '.__CLASS__.'::preSubmit instead.',
                E_USER_DEPRECATED
            );
        }

        $this->preSubmit($event);
    }
}
