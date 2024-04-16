<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[
    ORM\Embeddable
]
final readonly class Price
{
    #[
        ORM\Column(
            name: 'price',
            type: Types::INTEGER
        )
    ]
    public int $value;

    public function __construct(int $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }
}
