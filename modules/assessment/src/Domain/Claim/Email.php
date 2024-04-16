<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[
    ORM\Embeddable
]
final readonly class Email
{
    #[
        ORM\Column(
            name: 'email',
            type: Types::STRING
        )
    ]
    public string $value;

    public function __construct(string $value)
    {
        Assert::email($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }
}
