<?php

declare(strict_types=1);

namespace Lib\Domain\Id;

interface Id
{
    public function isEqual(self $otherId): bool;

    public function __toString(): string;

    public static function next(): self;
}
