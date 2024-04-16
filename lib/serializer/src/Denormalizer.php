<?php

declare(strict_types=1);

namespace Lib\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;

final readonly class Denormalizer implements DenormalizerInterface
{
    public function __construct(
        private SymfonyDenormalizerInterface $denormalizer
    ) {
    }


    /**
     * @inheritDoc
     */
    public function denormalize(mixed $data, string $type, array $context = []): object
    {
        return $this->denormalizer->denormalize(
            data: $data,
            type: $type,
            context: $context
        );
    }
}
