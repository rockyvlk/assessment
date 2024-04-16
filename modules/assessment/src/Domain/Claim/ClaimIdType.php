<?php

declare(strict_types=1);

namespace Assessment\Domain\Claim;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class ClaimIdType extends GuidType
{
    public const string NAME = 'assessment_claim_id';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value ? (string) $value : null;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClaimId
    {
        return $value ? new ClaimId((string) $value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
