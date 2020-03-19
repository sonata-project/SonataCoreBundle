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

namespace Sonata\Form\Fixtures;

use Symfony\Contracts\Translation\TranslatorInterface;

final class StubTranslator implements TranslatorInterface
{
    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null): string
    {
        return '[trans]'.strtr($id, $parameters).'[/trans]';
    }
}
