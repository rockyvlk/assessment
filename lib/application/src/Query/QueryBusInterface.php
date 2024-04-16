<?php

declare(strict_types=1);

namespace Lib\Application\Query;

interface QueryBusInterface
{
    /**
     * @template T
     * @param object<T> $query
     * @return T
     */
    public function dispatch(object $query);
}
