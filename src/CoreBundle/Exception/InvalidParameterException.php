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

namespace Sonata\CoreBundle\Exception;

@trigger_error(
    'The '.__NAMESPACE__.'\InvalidParameterException class is deprecated since version 3.12.0 and will be removed in 4.0.',
    E_USER_DEPRECATED
);

/**
 * @deprecated since sonata-project/core-bundle 3.12.0, to be removed in 4.0.
 */
class InvalidParameterException extends \RuntimeException
{
}
