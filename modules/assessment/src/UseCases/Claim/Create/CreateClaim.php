<?php

declare(strict_types=1);

namespace Assessment\UseCases\Claim\Create;

use Assessment\Domain\AssessmentType;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateClaim
{
    public function __construct(
        #[
            Assert\NotBlank,
            Assert\Choice(callback: [AssessmentType::class, 'values']),
        ]
        public string $assessmentType,
        #[
            Assert\Email,
            Assert\NotBlank,
        ]
        public string $email,
    ) {
    }
}
