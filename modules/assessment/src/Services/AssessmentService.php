<?php

declare(strict_types=1);

namespace Assessment\Services;

use Assessment\Domain\AssessmentType;

final readonly class AssessmentService implements AssessmentServiceInterface
{
    /**
     * @param array<array{string, array{
     *     name: string,
     *     price: string
     * }}> $assessments
     */
    public function __construct(private array $assessments)
    {
    }

    /**
     * @inheritDoc
     */
    public function getPriceList(): array
    {
        $prices = [];
        foreach ($this->assessments as $type => $assessment) {
            $prices[$type] = (int) $assessment['price'];
        }
        return $prices;
    }

    /**
     * @inheritDoc
     */
    public function getNameList(): array
    {
        $names = [];
        foreach ($this->assessments as $type => $assessment) {
            $names[$type] = $assessment['name'];
        }
        return $names;
    }

    public function getByAssessmentType(AssessmentType $assessmentType): int
    {
        return (int) $this->assessments[$assessmentType->value]['price'];
    }
}
