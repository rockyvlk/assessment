<?php

declare(strict_types=1);

namespace Lib\Domain\Id;

use Symfony\Component\Uid\Uuid;

final class UuidGenerator
{
    public static function generate(): string
    {
        return (string) Uuid::v4();
    }
}
