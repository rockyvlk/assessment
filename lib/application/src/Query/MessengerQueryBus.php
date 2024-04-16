<?php

declare(strict_types=1);

namespace Lib\Application\Query;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final readonly class MessengerQueryBus implements QueryBusInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(object $query)
    {
        try {
            return $this->messageBus
                ->dispatch($query)
                ->all(HandledStamp::class)[0]
                ->getResult();
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }
            throw $e;
        }
    }
}
