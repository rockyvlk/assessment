<?php

declare(strict_types=1);

namespace Lib\Serializer;

interface DenormalizerInterface
{
    /**
     * @template T
     * @param class-string<T> $type
     * @return T
     */
    public function denormalize(mixed $data, string $type, array $context = []): object;
}
