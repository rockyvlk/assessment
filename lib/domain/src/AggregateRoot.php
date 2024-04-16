<?php

declare(strict_types=1);

namespace Lib\Domain;

use Lib\Domain\Event\DomainEventInterface;

abstract class AggregateRoot
{
    /**
     * @psalm-var  list<DomainEventInterface> $recordedEvents
     */
    private array $recordedEvents = [];

    /**
     * @psalm-return list<DomainEventInterface>
     */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }

    protected function recordThat(DomainEventInterface $event): void
    {
        $this->recordedEvents[] = $event;
    }
}
