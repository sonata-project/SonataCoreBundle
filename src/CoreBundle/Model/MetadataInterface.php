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

namespace Sonata\CoreBundle\Model;

/**
 * @author Hugo Briand <briand@ekino.com>
 */
interface MetadataInterface
{
    public function getTitle(): string;

    public function getDescription(): ?string;

    /**
     * @return mixed
     */
    public function getImage();

    public function getDomain(): ?string;

    public function getOptions(): array;

    /**
     * @param mixed $default The default value if option not found
     *
     * @return mixed
     */
    public function getOption(string $name, $default = null);
}
