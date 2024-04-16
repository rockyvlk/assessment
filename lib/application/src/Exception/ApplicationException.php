<?php

declare(strict_types=1);

namespace Lib\Application\Exception;

use RuntimeException;
use Throwable;

class ApplicationException extends RuntimeException
{
    public function __construct(
        string $message,
        ?Throwable $previous = null,
        public readonly array $context = [],
    ) {
        parent::__construct(
            message: $message,
            previous: $previous
        );
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'context' => $this->context,
            'previous' => $this->getPrevious(),
        ];
    }
}
