<?php

declare(strict_types=1);

namespace Assessment\UseCases\Claim\Create;

use Assessment\Domain\AssessmentType;
use Assessment\Domain\Claim\Claim;
use Assessment\Domain\Claim\ClaimId;
use Assessment\Domain\Claim\ClaimRepositoryInterface;
use Assessment\Domain\Claim\Email;
use Assessment\Domain\Claim\Price;
use Assessment\Services\AssessmentServiceInterface;
use Lib\Domain\Doctrine\EntityFlusherInterface;
use Psr\Log\LoggerInterface;

final readonly class CreateClaimHandler
{
    public function __construct(
        private ClaimRepositoryInterface   $claimRepository,
        private EntityFlusherInterface     $entityFlusher,
        private AssessmentServiceInterface $priceProvider,
        private LoggerInterface            $assessmentLogger,
    ) {
    }

    public function __invoke(CreateClaim $command): void
    {
        try {
            $assessmentType = AssessmentType::from($command->assessmentType);
            $price = $this->priceProvider->getByAssessmentType($assessmentType);

            $claim = new Claim(
                ClaimId::next(),
                $assessmentType,
                new Price($price),
                new Email($command->email)
            );

            $this->claimRepository->add($claim);
            $this->entityFlusher->flush();

            $this->assessmentLogger->info('Заявка на оценку создана', [
                'command' => $command,
            ]);
        } catch (\Throwable $e) {
            $this->assessmentLogger->error('Ошибка создания заявки на оценку', [
                'command' => $command,
                'e' => $e
            ]);
            throw $e;
        }
    }
}
