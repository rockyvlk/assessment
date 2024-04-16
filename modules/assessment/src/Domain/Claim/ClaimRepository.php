<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

use Doctrine\ORM\EntityManagerInterface;
use Lib\Domain\Exception\EntityNotFoundException;

final readonly class ClaimRepository implements ClaimRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(ClaimId $id): Claim
    {
        $claim = $this->em->find(Claim::class, $id);

        if (!$claim) {
            throw new EntityNotFoundException(sprintf('Заявка на оценку с id %s не найдена', $id));
        }

        return $claim;
    }

    public function add(Claim $claim): void
    {
        $this->em->persist($claim);
    }
}
