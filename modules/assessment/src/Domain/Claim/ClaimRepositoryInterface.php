<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

interface ClaimRepositoryInterface
{
    public function get(ClaimId $id): Claim;

    public function add(Claim $claim): void;
}
