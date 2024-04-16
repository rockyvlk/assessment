<?php

declare(strict_types=1);

namespace Lib\Domain\Doctrine;

interface EntityFlusherInterface
{
    public function flush(): void;
}
