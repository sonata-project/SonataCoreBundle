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

namespace Sonata\CoreBundle\Validator\Constraints;

if (!class_exists(Sonata\Form\Validator\Constraints\InlineConstraint::class, false)) {
    @trigger_error(
        'The '.__NAMESPACE__.'\InlineConstraint class is deprecated since version 3.13.0 and will be removed in 4.0.'
        .' Use Sonata\Form\Validator\Constraint\InlineConstraint instead.',
        E_USER_DEPRECATED
    );
}

class_alias(
    \Sonata\Form\Validator\Constraints\InlineConstraint::class,
    __NAMESPACE__.'\InlineConstraint'
);

if (false) {
    /**
     * Constraint which allows inline-validation inside services.
     *
     * @Annotation
     * @Target({"CLASS"})
     *
     * @deprecated since sonata-project/core-bundle 3.13.0, to be removed in 4.0.
     */
    class InlineConstraint extends \Sonata\Form\Validator\Constraints\InlineConstraint
    {
    }
}
