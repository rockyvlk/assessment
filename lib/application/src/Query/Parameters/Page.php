<?php

declare(strict_types=1);

namespace Lib\Application\Query\Parameters;

final class Page
{
    public function __construct(
        public int $limit,
        public int $offset = 0,
    ) {
    }
}
