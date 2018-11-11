<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\CoreBundle\Form\DataTransformer;

use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\DataTransformerInterface;

class BooleanTypeToBooleanTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (true === $value or BooleanType::TYPE_YES === (int) $value) {
            return BooleanType::TYPE_YES;
        } elseif (false === $value or BooleanType::TYPE_NO === (int) $value) {
            return BooleanType::TYPE_NO;
        }

        return null;
    }

    public function reverseTransform($value)
    {
        if (BooleanType::TYPE_YES === $value) {
            return true;
        } elseif (BooleanType::TYPE_NO === $value) {
            return false;
        }

        return null;
    }
}
