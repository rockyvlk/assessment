<?php

declare(strict_types=1);

namespace Lib\Application\Command;

use Lib\Application\AsyncQueue;
use Lib\Application\Exception\ApplicationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Throwable;

final readonly class MessengerCommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function dispatch(object $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                $e = $e->getPrevious();
            }
            throw $e;
        } catch (ValidationFailedException $e) {
            $violations = $e->getViolations();

            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $this->logger->error(
                'Ошибка валидации сообщения',
                [
                    'message' => $command::class,
                    'violations' => $errors
                ]
            );
            throw new ApplicationException('Ошибка валидации сообщения ' . $command::class);
        }
    }
}
