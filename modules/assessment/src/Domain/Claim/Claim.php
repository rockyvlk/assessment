<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

use Assessment\Domain\AssessmentType;
use Doctrine\ORM\Mapping as ORM;
use Lib\Domain\AggregateRoot;
use Lib\Domain\Entity\Timestampable;


#[
    ORM\Entity,
    ORM\Table(
        name: 'assessment_claims'
    ),
]
class Claim extends AggregateRoot
{
    use Timestampable;

    #[
        ORM\Id,
        ORM\Column(
            type: ClaimIdType::NAME
        ),
    ]
    private ClaimId $id;

    #[
        ORM\Column(
            enumType: AssessmentType::class,
        ),
    ]
    private AssessmentType $assessmentType;

    #[
        ORM\Embedded(
            class: Price::class,
            columnPrefix: false
        ),
    ]
    private Price $price;

    #[
        ORM\Embedded(
            class: Email::class,
            columnPrefix: false
        ),
    ]
    private Email $ownerId;

    public function __construct(
        ClaimId        $id,
        AssessmentType $assessmentType,
        Price          $price,
        Email          $ownerId,
    ) {
        $this->id = $id;
        $this->assessmentType = $assessmentType;
        $this->price = $price;
        $this->ownerId = $ownerId;
        $this->recordThat(new ClaimCreated((string) $this->id));
    }
}
