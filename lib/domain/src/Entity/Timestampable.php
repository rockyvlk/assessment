<?php

declare(strict_types=1);

namespace Lib\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Gedmo\Mapping\Annotation as Gedmo;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    #[
        ORM\Column(
            type: Types::DATETIME_IMMUTABLE
        ),
        Gedmo\Timestampable(on: 'create')
    ]
    private DateTimeImmutable $createdAt;

    #[
        ORM\Column(
            type: Types::DATETIME_IMMUTABLE
        ),
        Gedmo\Timestampable(on: 'update')
    ]
    private DateTimeImmutable $updatedAt;
}
