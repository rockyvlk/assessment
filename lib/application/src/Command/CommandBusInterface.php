<?php

declare(strict_types=1);

namespace Lib\Application\Command;

use Throwable;

interface CommandBusInterface
{
    /**
     * @throws Throwable
     */
    public function dispatch(object $command): void;
}
