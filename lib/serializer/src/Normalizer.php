<?php

declare(strict_types=1);

namespace Lib\Serializer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface as SymfonyNormalizerInterface;

final class Normalizer implements NormalizerInterface
{
    public function __construct(
        private readonly SymfonyNormalizerInterface $normalizer
    ) {
    }

    public function normalize(object $object): array
    {
        return $this->normalizer->normalize($object);
    }
}
