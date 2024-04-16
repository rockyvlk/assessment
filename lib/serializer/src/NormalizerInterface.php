<?php

declare(strict_types=1);

namespace Lib\Serializer;

interface NormalizerInterface
{
    public function normalize(object $object): array;
}
