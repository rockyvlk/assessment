<?php

declare(strict_types=1);

namespace Lib\Domain\Event;

use DateTimeImmutable;
use Webmozart\Assert\Assert;

abstract class DomainEvent implements DomainEventInterface
{
    public function __construct(
        public string $id,
        public DateTimeImmutable $createdOn = new DateTimeImmutable()
    ) {
        Assert::uuid($this->id);
    }
}
