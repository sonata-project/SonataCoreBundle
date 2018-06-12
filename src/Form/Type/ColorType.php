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
use Symfony\Component\Form\Extension\Core\Type\TextType;

if (class_exists('Symfony\Component\Form\Extension\Core\Type\ColorType')) {
    @trigger_error(
        'The '.__NAMESPACE__.'\ColorType class is deprecated since version 3.10 and will be removed in 4.0.'
        .' Use Symfony\Component\Form\Extension\Core\Type\ColorType instead.',
        E_USER_DEPRECATED
    );
}

/**
 * NEXT_MAJOR: remove this class.
 *
 * @deprecated since version 3.10, to be removed in 4.0. Use Symfony\Component\Form\Extension\Core\Type\ColorType instead
 */
final class ColorType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'sonata_type_color';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
