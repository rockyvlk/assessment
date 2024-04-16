<?php

declare(strict_types=1);

namespace Assessment\Domain;

use Lib\Domain\Enum\ArrayableEnum;

enum AssessmentType: string
{
    use ArrayableEnum;

    case Auto = 'auto';
    case Apartment = 'apartment';
    case Business = 'business';
}
