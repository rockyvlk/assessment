<?php

declare(strict_types=1);

namespace Lib\Domain\Id;

use Webmozart\Assert\Assert;

abstract class Uuid implements Id
{
    private string $value;

    final public function __construct(string $value)
    {
        Assert::uuid($value);
        $this->value = mb_strtolower($value);
    }

    public function isEqual(Id $otherId): bool
    {
        return $otherId instanceof static && $otherId->value === $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function next(): static
    {
        return new static(UuidGenerator::generate());
    }
}
