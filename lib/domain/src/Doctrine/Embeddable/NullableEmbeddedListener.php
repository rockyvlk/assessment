<?php

declare(strict_types=1);

namespace Lib\Domain\Doctrine\Embeddable;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Events;
use ReflectionObject;

#[
    AsDoctrineListener(event: Events::postLoad),
]
final readonly class NullableEmbeddedListener
{
    public function postLoad(PostLoadEventArgs $args): void
    {
        $entity = $args->getObject();

        $objectReflection = new ReflectionObject($entity);
        foreach ($objectReflection->getProperties() as $property) {

            $attributes = $property->getAttributes(NullableEmbedded::class);
            $isNullable = (bool) array_pop($attributes);

            if ($isNullable) {
                $property->setAccessible(true);
                $value = $property->getValue($entity);
                if ($this->allPropertiesAreNull($value)) {
                    $property->setValue($entity, null);
                }
            }
        }
    }

    private function allPropertiesAreNull($object): bool
    {
        $objectReflection = new ReflectionObject($object);
        foreach ($objectReflection->getProperties() as $property) {
            $property->setAccessible(true);
            if (null !== $property->getValue($object)) {
                return false;
            }
        }
        return true;
    }
}
