<?php

declare(strict_types=1);

namespace Assessment\Services;

use Assessment\Domain\AssessmentType;

interface AssessmentServiceInterface
{
    /**
     * @return array<array{string, int}>
     */
    public function getPriceList(): array;

    /**
     * @return array<array{string, string}>
     */
    public function getNameList(): array;

    public function getByAssessmentType(AssessmentType $assessmentType): int;
}
