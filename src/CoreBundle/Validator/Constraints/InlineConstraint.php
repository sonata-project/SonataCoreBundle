<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Validator\Constraints;

@trigger_error(
    'The '.__NAMESPACE__.'\InlineConstraint class is deprecated since version 3.x and will be removed in 4.0.'
    .' Use Sonata\Form\Validator\Constraint\InlineConstraint instead.',
    E_USER_DEPRECATED
);

/**
 * Constraint which allows inline-validation inside services.
 *
 * @Annotation
 * @Target({"CLASS"})
 *
 * @deprecated Since version 3.x, to be removed in 4.0.
 */
class InlineConstraint extends \Sonata\Form\Validator\Constraints\InlineConstraint
{
}
