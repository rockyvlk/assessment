<?php

declare(strict_types=1);

namespace Lib\Domain\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

final class EntityFlusher implements EntityFlusherInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function flush(): void
    {
        $this->em->flush();
    }
}
