<?php

declare(strict_types=1);

namespace Lib\Domain\Exception;

use RuntimeException;
use Webmozart\Assert\Assert;

final class EntityNotFoundException extends RuntimeException
{
    public function __construct(string $message)
    {
        Assert::notEmpty($message);
        parent::__construct($message);
    }
}
