<?php

declare(strict_types=1);

namespace Lib\Domain\Event;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Lib\Domain\AggregateRoot;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[
    AsDoctrineListener(event: Events::onFlush),
    AsDoctrineListener(event: Events::postFlush),
]
final readonly class DomainEventListener
{
    /**
     * @param ArrayCollection<int,AggregateRoot> $entities
     */
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private ArrayCollection $entities = new ArrayCollection(),
    ) {
    }

    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $unitOfWork = $eventArgs->getObjectManager()->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $this->entities->add($entity);
        }

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $this->entities->add($entity);
        }

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            $this->entities->add($entity);
        }

        foreach ($unitOfWork->getScheduledCollectionUpdates() as $collection) {
            $this->entities->add($collection->getOwner());
        }

        foreach ($unitOfWork->getScheduledCollectionDeletions() as $collection) {
            $this->entities->add($collection->getOwner());
        }
    }

    public function postFlush(PostFlushEventArgs $eventArgs): void
    {
        foreach ($this->entities as $entity) {
            if ($entity instanceof AggregateRoot) {
                foreach ($entity->releaseEvents() as $domainEvent) {
                    $this->eventDispatcher->dispatch($domainEvent);
                }
            }
        }
    }
}
